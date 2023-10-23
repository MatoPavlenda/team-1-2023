<?php

namespace App\Controller\Practice;

use App\Entity\CompanyEmployee;
use App\Entity\PracticeOffer;
use App\Entity\User;
use App\Repository\CompanyRepository;
use App\Repository\PracticeOfferRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class CreateOfferController extends AbstractController
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
     * @var PracticeOfferRepository
     */
    private $practiceOfferRepository;


    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        PracticeOfferRepository $practiceOfferRepository
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->practiceOfferRepository = $practiceOfferRepository;
    }

    /**
     * @Route("/api/practice/create/offer", name="practice_create_offer")
     */
    public function yourAction(Request $request, Security $security)
    {
        $title = $request->get('title');
        $description = $request->get('description') ?? '';
        $start = $request->get('start');
        $end = $request->get('end');
        $student_count = $request->get('student_count');

        /** @var User $user */
        $user = $security->getUser();
        /** @var CompanyEmployee $companyEmployee */
        $companyEmployee = $user->getEmployees()->getValues()[0];


        $validationResult = $this->validationService->validateVariables(
            [
                [
                    'value' => $title,
                    'name' => 'title',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $start,
                    'name' => 'start',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'datetime'
                        ]
                    ]
                ],
                [
                    'value' => $end,
                    'name' => 'end',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'datetime'
                        ]
                    ]
                ],
                [
                    'value' => $student_count,
                    'name' => 'student_count',
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

        $practiceEntity = $this->practiceOfferRepository->create();

        $practiceEntity->setTutor($companyEmployee);
        $practiceEntity->setTitle($title);
        $practiceEntity->setDescription($description);
        $practiceEntity->setStart(new \DateTime($start));
        $practiceEntity->setEnd(new \DateTime($end));
        $practiceEntity->setCreateTime(new \DateTime());
        $practiceEntity->setStudentCount($student_count);

        $this->practiceOfferRepository->add($practiceEntity, true);

        return $this->responseService->createSuccessfulResponse();
    }
}
