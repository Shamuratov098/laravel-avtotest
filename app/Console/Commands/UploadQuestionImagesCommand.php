<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('questions:upload-images {--force : Re-upload even if image_url already looks like a URL}')]
#[Description('Lokal storage/app/public/questions ichidagi rasmlarni MinIO ga yuklash va image_url ni yangilash')]
class UploadQuestionImagesCommand extends Command
{
    public function handle(): int
    {
        $force = (bool) $this->option('force');
        $localDisk = Storage::disk('public');
        $remote = Storage::disk('minio');

        $questions = Question::query()
            ->whereNotNull('image_url')
            ->where('image_url', '!=', '')
            ->get(['id', 'image_url']);

        $uploaded = 0;
        $skipped = 0;
        $missing = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar($questions->count());
        $bar->start();

        foreach ($questions as $question) {
            $value = $question->image_url;

            if (!$force && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
                $skipped++;
                $bar->advance();
                continue;
            }

            $filename = ltrim(str_starts_with($value, 'questions/') ? substr($value, 10) : $value, '/');

            if (pathinfo($filename, PATHINFO_EXTENSION) === '') {
                $filename .= '.jpg';
            }

            $localPath = 'questions/' . $filename;
            $remotePath = 'questions/' . $filename;

            if (!$localDisk->exists($localPath)) {
                $missing++;
                $this->newLine();
                $this->warn("Topilmadi: {$localPath} (Question #{$question->id})");
                $bar->advance();
                continue;
            }

            try {
                $remote->put($remotePath, $localDisk->get($localPath), 'public');
                $question->update(['image_url' => $remote->url($remotePath)]);
                $uploaded++;
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->error("Xato: {$remotePath} — " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Yuklandi: {$uploaded}");
        $this->info("O'tkazib yuborildi (URL): {$skipped}");
        $this->info("Topilmadi (lokal): {$missing}");
        $this->info("Xato: {$failed}");

        return self::SUCCESS;
    }
}
