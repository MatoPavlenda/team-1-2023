<?php

namespace App\Controller\Practice;

use App\Entity\PracticeOffer;
use App\Entity\Student;
use App\Entity\StudyProgram;
use App\Entity\User;
use App\Repository\PracticeOfferRepository;
use App\Repository\StudentRepository;
use App\Repository\StudyProgramRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class GetPractices extends AbstractController
{
    /**
     * @var StudyProgramRepository
     */
    private $studyProgramRepository;

    /**
     * @var PracticeOfferRepository
     */
    private $practiceOfferRepository;


    public function __construct(
        PracticeOfferRepository $practiceOfferRepository,
        ResponseService $responseService
    )
    {
        $this->practiceOfferRepository = $practiceOfferRepository;
        $this->responseService = $responseService;
    }

    /**
     * @Route("/api/practice/get/all", name="practice_get_all")
     */
    public function yourAction()
    {
        /** @var PracticeOffer[] $studyPrograms */
        $practiceOffers = $this->practiceOfferRepository->findAll();

        $practiceOffersArray = [];
        foreach ($practiceOffers as $practiceOffer) {
            $practiceOffersArray[] = [
                'id' => $practiceOffer->getId(),
                'title' //TODO - Tu som skoncil, spravil get all na vsetky practice
            ];
        }
        $practiceOffersJson = json_encode($practiceOffersArray);

        return $this->responseService->createSuccessfulResponse();
    }
}
