<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Question;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class QuestionService
{

    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private CategoryRepositoryInterface $categoryRepository
    )
    {

    }
    /*  public function __construct(private QuestionRepository $questionRepository)
      {

      }*/

    /**
     * @throws Exception
     */
    public function getQuestionByCategoryId(int $id): Collection
    {

        $this->categoryRepository->findById($id);
        return $this->questionRepository->getQuestionsByCategoryId($id);
    }

    public function getRandomTest(): Collection
    {
        return $this->questionRepository->getRandomTest();
    }
}
