<?php

namespace App\Controller\StudyProgram;

use App\Entity\Student;
use App\Entity\StudyProgram;
use App\Entity\User;
use App\Repository\StudentRepository;
use App\Repository\StudyProgramRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class GetPrograms extends AbstractController
{
    /**
     * @var StudyProgramRepository
     */
    private $studyProgramRepository;

    /**
     * @var StudyProgramRepository
     */
    private $responseService;


    public function __construct(
        StudyProgramRepository $studyProgramRepository,
        ResponseService $responseService
    )
    {
        $this->studyProgramRepository = $studyProgramRepository;
        $this->responseService = $responseService;
    }

    /**
     * @Route("/api/study-program/get/all", name="studyProgram_get_all")
     */
    public function yourAction(Request $request, Security $security)
    {
        /** @var StudyProgram[] $studyPrograms */
        $studyPrograms = $this->studyProgramRepository->findAll();

        $studyProgramArray = [];
        foreach ($studyPrograms as $studyProgram) {
            $studyProgramArray[] = [
                'id' => $studyProgram->getId(),
                'name' => $studyProgram->getName()
            ];
        }
        $studyProgramsJson = json_encode($studyProgramArray);

        return $this->responseService->createDataResponse($studyProgramsJson);
    }
}
