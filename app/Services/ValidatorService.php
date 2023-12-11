<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ValidatorService
{
    /**
     * @var ResponseService
     */
    private $responseService;

    public function __construct(
        ResponseService $responseService
    )
    {
        $this->responseService = $responseService;
    }

    public function validateVariables(array $variablesAndRequirements)
    {
        foreach ($variablesAndRequirements as $variableAndRequirement) {
            $variableValue = $variableAndRequirement['value'];
            $variableName = $variableAndRequirement['name'];
            $requirements = $variableAndRequirement['requirements'];

            $result = $this->validateVariable($variableName, $variableValue, $requirements);

            if ($result['isValid'] == false) {
                return $result;
            }
        }

        return true;
    }

    public function giveValidationResponseError($validationResult) {
        switch ($validationResult['failedCondition']) {
            case 'non_empty':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} is empty");
                break;

            case 'datetime':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} is not in datetime format");
                break;

            case 'length':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} length is not {$validationResult['failedConditionValue']} characters");
                break;

            case 'min_length':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} is shorter than {$validationResult['failedConditionValue']} characters");
                break;

            case 'max_length':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} is longer than {$validationResult['failedConditionValue']} characters");
                break;

            case 'digits':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} can contain only numbers");
                break;

            case 'postal':
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} does not have correct postal format");
                break;

            default:
                return $this->responseService->createErrorResponse("Variable {$validationResult['variable']} failed some check");
                break;
        }
    }

    private function validateVariable($variableName, $value, $requirements)
    {
        $validationResult = [
            'variable' => $variableName,
            'isValid' => true,
            'failedCondition' => null,
        ];

        foreach ($requirements as $requirement) {
            switch ($requirement['type']) {
                case 'non_empty':
                    if (empty($value)) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'non_empty';
                    }
                    break;

                case 'length':
                    $length = $requirement['value'];
                    if (strlen($value) != $length) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = '$length';
                        $validationResult['failedConditionValue'] = $length;
                    }
                    break;

                case 'min_length':
                    $minLength = $requirement['value'];
                    if (strlen($value) < $minLength) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'min_length';
                        $validationResult['failedConditionValue'] = $minLength;
                    }
                    break;

                case 'max_length':
                    $maxLength = $requirement['value'];
                    if (strlen($value) > $maxLength) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'max_length';
                        $validationResult['failedConditionValue'] = $maxLength;
                    }
                    break;

                case 'digits':
                    if (!ctype_digit($value)) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'digits';
                    }
                    break;

                case 'postal':
                    if (!preg_match('/^\d{5}$|^\d{3}\s\d{2}$/', $value)) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'postal';
                    }
                    break;

                case 'datetime':
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);
                    if (!$date || $date->format('Y-m-d H:i:s') !== $value) {
                        $validationResult['isValid'] = false;
                        $validationResult['failedCondition'] = 'datetime';
                    }
                    break;

//                default:
//                    $validationResult['isValid'] = false;
//                    $validationResult['failedCondition'] = 'invalid_requirement';
//                    break;
            }

            if (!$validationResult['isValid']) {
                break; // If any requirement fails, exit the loop
            }
        }

        return $validationResult;
    }
}
