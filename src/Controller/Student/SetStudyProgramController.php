<?php

namespace App\Controller\Student;

use App\Entity\Student;
use App\Entity\User;
use App\Repository\StudentRepository;
use App\Repository\StudyProgramRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SetStudyProgramController extends AbstractController
{
    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ValidatorService
     */
    private $validationService;

    /**
     * @var StudyProgramRepository
     */
    private $studyProgramRepository;

    /**
     * @var StudentRepository
     */
    private $studentRepository;


    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        StudyProgramRepository $studyProgramRepository,
        StudentRepository $studentRepository
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->studyProgramRepository = $studyProgramRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/api/student/set/study-program", name="student_set_studyProgram")
     */
    public function yourAction(Request $request, Security $security)
    {
        $study_program_id = $request->get('study_program_id');

        /** @var User $user */
        $user = $security->getUser();
        /** @var Student $student */
        $student = $user->getStudents()->getValues()[0];

        $validationResult = $this->validationService->validateVariables(
            [
                [
                    'value' => $study_program_id,
                    'name' => 'study_program_id',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digits'
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult !== true) {
            return $this->validationService->giveValidationResponseError($validationResult);
        }

        $studyProgramEntity = $this->studyProgramRepository->find($study_program_id);

        $student->setStudyProgram($studyProgramEntity);

        $this->studentRepository->add($student, true);

        return $this->responseService->createSuccessfulResponse();
    }
}
