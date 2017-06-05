<?php

class Msales_Sniffs_WhiteSpace_AssignmentSpacingSniff implements PHP_CodeSniffer_Sniff
{
    const STRICT_TYPES = 'strict_types';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return PHP_CodeSniffer_Tokens::$assignmentTokens;
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $isStrictTypes = self::STRICT_TYPES === $tokens[$stackPtr-1]['content']
            || self::STRICT_TYPES === $tokens[$stackPtr-2]['content'];

        if ($isStrictTypes) {
            if ($tokens[$stackPtr-1]['content'] !== self::STRICT_TYPES || $tokens[$stackPtr+1]['code'] !==  T_LNUMBER) {
                $phpcsFile->addError(
                    'No whitespaces should be surrounding strict types declaration equal sign',
                    $stackPtr,
                    'Invalid'
                );
            }

            return;
        }

        if ($tokens[$stackPtr -1]['code'] !== T_WHITESPACE
            || $tokens[$stackPtr +1]['code'] !== T_WHITESPACE
        ) {
            $phpcsFile->addError(
                'Add a single space around assignment operators',
                $stackPtr,
                'Invalid'
            );
        }
    }
}
