<?php

/**
 * @author Roman Naumenko <naumenko_subscr@mail.ru>
 */

declare(strict_types=1);

namespace App\Core\Helper;

use Symfony\Component\Form\FormInterface;

class FormErrorsHelper
{
    public function getErrors(FormInterface $form): array
    {
        $formErrors = [
            'fields' => $this->getFieldsErrors($form),
            'errors' => [],
        ];

        foreach ($form->getErrors() as $error) {
            $formErrors['errors'][] = $error->getMessage();
        }

        return $formErrors;
    }


    private function getFieldsErrors(FormInterface $form, string $currentFieldName = null): ?array
    {
        $result = [];

        if (!$form->isSubmitted() || $form->isValid()) {
            return $result;
        }

        // Исключаем глобальные ошибки формы, т.к. они заполняются в методе getErrors()
        if (null !== $currentFieldName) {
            $errors = $form->getErrors();

            if (count($errors) > 0) {
                $result = ['errors' => []];

                foreach ($errors as $error) {
                    $result['errors'][] = $error->getMessage();
                }
            }
        }

        if ($form->count() > 0) {
            $childErrors = [];

            foreach ($form->all() as $child) {
                if (!$child->isValid()) {
                    $fieldName = $child->getName();

                    $childErrors[$fieldName] = self::getFieldsErrors($child, $fieldName);
                }
            }

            if (count($childErrors) > 0) {
                $result = $childErrors;
            }
        }

        return $result;
    }


    /**
     * Create simple object with 1 global message
     */
    public function error(string $message): array
    {
        return [
            'fields' => [],
            'errors' => [$message],
        ];
    }
}
