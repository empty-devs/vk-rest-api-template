<?php

namespace Api\Services\Validation\Request\rules;

use Api\Constants\Validation\ValidationRuleConstant;
use Api\Interfaces\Service\Validation\rules\Shared\BaseValidationRule;

final class FileValidationRule extends BaseValidationRule
{
    protected function main(): void
    {
        if ($this->required && (!isset($this->request_params[$this->field]['error']) ||
                $this->request_params[$this->field]['error'] !== UPLOAD_ERR_OK)) {
            $this->addError(
                ValidationRuleConstant::TYPE_FILE,
                $this->field.' must be a valid uploaded file.'
            );
        }
    }

    /**
     * @param array<string> $mime_types
     * @return $this
     */
    public function setMime(array $mime_types): self
    {
        if ($this->required && !in_array($this->request_params[$this->field]['type'], $mime_types, true)) {
            $this->addError(
                ValidationRuleConstant::TYPE_MIME,
                $this->field.' must be one of the following types: '.implode(', ', $mime_types)
            );
        }

        return $this;
    }

    public function setMin(int $min): self
    {
        if ($this->required && $this->request_params[$this->field]['size'] < $min * 1024) {
            $this->addError(
                ValidationRuleConstant::TYPE_MIN,
                $this->field.' must be at least '.$min.' KB.'
            );
        }

        return $this;
    }

    public function setMax(int $max): self
    {
        if ($this->required && $this->request_params[$this->field]['size'] > $max * 1024) {
            $this->addError(
                ValidationRuleConstant::TYPE_MAX,
                $this->field.' must be less than '.$max.' KB.'
            );
        }

        return $this;
    }
}