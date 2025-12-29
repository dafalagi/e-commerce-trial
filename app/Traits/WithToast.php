<?php

namespace App\Traits;

trait WithToast
{
    public function showToast($type, $message)
    {
        $this->dispatch('showToast', $type, $message);
    }

    public function showErrorToast($message)
    {
        $this->showToast('error', $message);
    }

    public function showSuccessToast($message)
    {
        $this->showToast('success', $message);
    }

    public function showWarningToast($message)
    {
        $this->showToast('warning', $message);
    }

    public function showInfoToast($message)
    {
        $this->showToast('info', $message);
    }
}