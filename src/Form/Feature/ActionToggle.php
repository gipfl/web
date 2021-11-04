<?php

namespace gipfl\Web\Form\Feature;

use ipl\Html\FormElement\SubmitElement;

trait ActionToggle
{
    /** @var boolean|null */
    protected $hasBeenSubmitted;

    protected function provideActionWithConfirmation($labelNext, $labelConfirm, $labelCancel, $title = null)
    {
        $next = new SubmitElement('next', [
            'class' => 'link-button',
            'label' => sprintf('[ %s ]', $labelNext),
            'title' => $title,
        ]);
        $submit = new SubmitElement('submit', [
            'class' => 'link-button',
            'label' => $labelConfirm
        ]);
        $cancel = new SubmitElement('cancel', [
            'class' => 'link-button',
            'label' => $labelCancel
        ]);
        $this->toggleNextSubmitCancel($next, $submit, $cancel);
    }

    public function setSubmitted($submitted = true)
    {
        $this->hasBeenSubmitted = (bool) $submitted;

        return $this;
    }

    public function hasBeenSubmitted()
    {
        /** @var \gipfl\Web\Form $this */
        if ($this->hasBeenSubmitted === null) {
            return parent::hasBeenSubmitted();
        } else {
            return $this->hasBeenSubmitted;
        }
    }

    protected function toggleNextSubmitCancel(
        SubmitElement $next,
        SubmitElement $submit,
        SubmitElement $cancel,
                      $submitFirst = true
    ) {
        /** @var \gipfl\Web\Form $this */
        if ($this->hasBeenSent()) {
            if ($submitFirst) {
                $this->addElement($submit);
                $this->addElement($cancel);
            } else {
                $this->addElement($cancel);
                $this->addElement($submit);
            }
            if ($cancel->hasBeenPressed()) {
                // HINT: we might also want to redirect on cancel and stop here,
                //       but currently we have no Response
                $this->setSubmitted(false);
                $this->remove($submit);
                $this->remove($cancel);
                $this->add($next);
                $this->setSubmitButton($next);
            } else {
                $this->setSubmitButton($submit);
                $this->remove($next);
            }
        } else {
            $this->addElement($next);
        }
    }
}
