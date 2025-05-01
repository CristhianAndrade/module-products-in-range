<?php
/**
 * @author Cristhian Andrade
 * @copyright 2025 GPL3
 * @license GPL-3.0
 */
declare(strict_types=1);

namespace  CrimsonAgility\ProductsInRange\Model\Validator;

use Magento\Framework\Validator\AbstractValidator;

/**
 * Validate product in range Data
 */
class ProductsInRangeValidate extends AbstractValidator
{
    const string INVALID_REQUIRED = 'invalid_required';
    const string INVALID_NUMBER = 'invalid_number';
    const string INVALID_HIGH_GREATER_THAN_LOW_RANGE  = 'invalid_high_greater_than_low_range';

    /** @var array */
    protected array $messageTemplates = [
        self::INVALID_REQUIRED => '%1 is required',
        self::INVALID_NUMBER => '%1 need to be a number and 0 or greater',
        self::INVALID_HIGH_GREATER_THAN_LOW_RANGE => 'High Range need to be greater than "Low Range" and no more than 5x higher'
    ];

    /**
     * Validate field
     *
     * @param mixed $value
     * @return bool
     */
    public function isValid(mixed $value): bool
    {

        if (empty($value['field_value'])) {
            $this->_addMessages(
                [
                    __(
                        $this->messageTemplates[self::INVALID_REQUIRED],
                        $value['field_name']
                    )
                ]
            );
            return false;
        }

        if (!is_numeric($value['field_value']) || $value['field_value'] < 0) {
            $this->_addMessages(
                [
                    __(
                        $this->messageTemplates[self::INVALID_NUMBER],
                        $value['field_name']
                    )
                ]
            );
            return false;
        }

        if (
            $value['field_name'] === 'High Range' &&
            (
                $value['field_value'] <= $value['compare_field_value'] ||
                $value['field_value'] > (5 * $value['compare_field_value'])
            )
        ) {
            $this->_addMessages(
                [
                    __($this->messageTemplates[self::INVALID_HIGH_GREATER_THAN_LOW_RANGE])
                ]
            );
            return false;
        }

        return true;
    }
}
