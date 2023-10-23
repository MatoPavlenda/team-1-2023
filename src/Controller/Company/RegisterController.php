<?php

namespace App\Controller\Company;

use App\Repository\CompanyRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
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
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        CompanyRepository $companyRepository
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @Route("/api/company/register", name="company_register")
     */
    public function yourAction(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $name = $request->get('name');
        $street = $request->get('street');
        $city = $request->get('city');
        $postal_code = $request->get('postal_code');
        $ico = $request->get('ico');

        $validationResult = $this->validationService->validateVariables(
            [
                [
                    'value' => $name,
                    'name' => 'name',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $street,
                    'name' => 'street',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $city,
                    'name' => 'city',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ]
                    ]
                ],
                [
                    'value' => $postal_code,
                    'name' => 'postal_code',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'postal'
                        ]
                    ]
                ],
                [
                    'value' => $ico,
                    'name' => 'ico',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digits'
                        ],
                        [
                            'type' => 'length',
                            'value' => '8'
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult === true) {
            $companyEntity = $this->companyRepository->create();

            $companyEntity->setName($name);
            $companyEntity->setStreet($street);
            $companyEntity->setCity($city);
            $companyEntity->setPostalCode($postal_code);
            $companyEntity->setIco($ico);
            $companyEntity->setRegistrationTime(new \DateTime());

            $this->companyRepository->add($companyEntity, true);

            return $this->responseService->createSuccessfulResponse();
        } else {
            return $this->validationService->giveValidationResponseError($validationResult);
        }
    }
}
