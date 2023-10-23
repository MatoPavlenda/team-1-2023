<?php

namespace App\Controller\Company;

use App\Repository\CompanyRepository;
use App\Repository\CompanySchoolContractRepository;
use App\Service\ResponseService;
use App\Service\ValidatorService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateContractController extends AbstractController
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
     * @var CompanySchoolContractRepository
     */
    private $companySchoolContractRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    public function __construct(
        ResponseService $responseService,
        ValidatorService $validationService,
        CompanySchoolContractRepository $companySchoolContractRepository,
        CompanyRepository $companyRepository
    )
    {
        $this->responseService = $responseService;
        $this->validationService = $validationService;
        $this->companySchoolContractRepository = $companySchoolContractRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @Route("/api/company/create/contract", name="company_create_contract")
     */
    public function yourAction(Request $request, ParameterBagInterface $parameterBag)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $company_id = $request->get('company_id');

        $validationResult = $this->validationService->validateVariables(
            [
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
                    'value' => $company_id,
                    'name' => 'company_id',
                    'requirements' => [
                        [
                            'type' => 'non_empty'
                        ],
                        [
                            'type' => 'digit'
                        ]
                    ]
                ]
            ]
        );

        if ($validationResult !== true) {
            return $this->validationService->giveValidationResponseError($validationResult);
        }

        try {
            /** @var UploadedFile $file */
            $file = $request->files->get('file');

            // Check if a file was actually uploaded
            if ($file instanceof UploadedFile) {
                $projectDir = $parameterBag->get('kernel.project_dir');
                $targetDirectory = $projectDir . '/uploads/company-school-contract';

                // Ensure the target directory exists
                if (!file_exists($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                // Move the uploaded file to the target location
                $randomName = bin2hex(random_bytes(4));
                $originalFileName = $file->getClientOriginalName();
                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $targetFileName = $randomName . '.' . $extension;
                dump($targetDirectory);
                dump($targetFileName);
                $file->move($targetDirectory, $targetFileName);
            } else {
                return $this->responseService->createErrorResponse('File not uploaded');
            }
        } catch (\Exception $e) {
            return $this->responseService->createErrorResponse('There is problem with file, try insert it again');
        }

        $contractEntity = $this->companySchoolContractRepository->create();
        $comapnyEntity = $this->companyRepository->find($company_id);

        $contractEntity->setStart(new \DateTime($start));
        $contractEntity->setEnd(new \DateTime($end));
        $contractEntity->setFilename($targetFileName);
        $contractEntity->setCreateTime(new \DateTime());
        $contractEntity->setCompany($comapnyEntity);

        $this->companySchoolContractRepository->add($contractEntity, true);

        return $this->responseService->createSuccessfulResponse();
    }
}
