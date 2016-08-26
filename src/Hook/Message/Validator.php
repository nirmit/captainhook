<?php
/**
 * This file is part of HookMeUp.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace HookMeUp\Hook\Message;

use HookMeUp\Git\CommitMessage;
use HookMeUp\Hook\Message\Validator\Rule;

/**
 * Class Validator
 *
 * @package HookMeUp
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/hookmeup
 * @since   Class available since Release 0.9.0
 */
class Validator
{
    /**
     * List of rules to check
     *
     * @var \HookMeUp\Hook\Message\Validator\Rule[]
     */
    private $rules = [];

    /**
     * Set rules to check.
     *
     * @param  \HookMeUp\Hook\Message\Validator\Rule[] $rules
     * @return \HookMeUp\Hook\Message\Validator
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Add a rule to the list.
     *
     * @param  \HookMeUp\Hook\Message\Validator\Rule $rule
     * @return \HookMeUp\Hook\Message\Validator
     */
    public function addRule(Rule $rule)
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * Validates all rules.
     *
     * @param  \HookMeUp\Git\CommitMessage $msg
     * @throws \RuntimeException
     */
    public function validate(CommitMessage $msg)
    {
        foreach ($this->rules as $rule) {
            if (!$rule->pass($msg)) {
                throw new \RuntimeException($rule->getHint());
            }
        }
    }
}