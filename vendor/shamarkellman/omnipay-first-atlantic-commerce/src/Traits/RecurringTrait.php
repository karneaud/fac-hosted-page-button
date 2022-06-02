<?php

namespace Omnipay\FirstAtlanticCommerce\Traits;

use Omnipay\FirstAtlanticCommerce\Enums\TransactionCode;

trait RecurringTrait
{
    
    protected function getRecurringTransactionCode(): int
    {
        return $this->getTransactionCode() + ($this->getIsFreeTrial()? TransactionCode::INITIAL_RECURRING_FREE_TRIALS : ($this->getIsSubsequentRecurring() ? TransactionCode::SUBSEQUENT_RECURRING : TransactionCode::INITIAL_RECURRING));            
    }
    
    public function setIsFreeTrial(bool $value = false) 
    {
        $this->setParameter('isFreeTrial', $value );
    }
    
    public function getIsFreeTrial() 
    {
       return $this->getParameter('isFreeTrial');
    }
    
    public function setIsSubsequentRecurring(bool $value = false) 
    {
        $this->setParameter('isSubsequentRecurring', $value );
    }
    
    public function getIsSubsequentRecurring() 
    {
       return $this->getParameter('isSubsequentRecurring');
    }
    
    public function setExecutionDate($value)
    {
        return $this->setParameter('executionDate', $value);
    }

    public function getExecutionDate()
    {
        return $this->getParameter('executionDate');
    }

    public function setIsRecurring(bool $value = false)
    {
        return $this->setParameter('isRecurring', $value );
    }

    public function getIsRecurring()
    {
        return $this->getParameter('isRecurring');
    }

    public function setFrequency($value = 'M')
    {
        return $this->setParameter('frequency', $value);
    }

    public function getFrequency()
    {
        return $this->getParameter('frequency');
    }    
    
    public function setNumberOfRecurrences(int $value)
    {
        return $this->setParameter('numberOfRecurrences', $value);
    }

    public function getNumberOfRecurrences()
    {
        return $this->getParameter('numberOfRecurrences');
    }
}
