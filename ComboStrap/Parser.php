<?php

namespace ComboStrap;

use Doku_Handler;
use dokuwiki\Parsing\Handler;
use dokuwiki\Parsing\ModeRegistry;

class Parser
{


    /**
     * @param $markup - the markup
     * @return Doku_Handler - the handler
     */
    public static function parseMarkupToHandler($markup): Doku_Handler
    {
        global $ID;
        $keep = $ID;
        global $ACT;
        $keepAct = $ACT;
        if ($ID === null) {
            $ID = ExecutionContext::getActualOrCreateFromEnv()->getConfig()->getDefaultContextPath()->getWikiId();
        }
        try {
            /**
             * Fragment
             */
            $ACT = ExecutionContext::PREVIEW_ACTION;

            $dateVersion = getVersionData()['date'];
            if ($dateVersion >= '2026-07-14') {
                // code for versions newer than 2026-07-14
                // when the markdown feature was added
                global $conf;
                $registry = new ModeRegistry($conf['syntax']);
                $handler = new Handler($registry);
                $parser = new \dokuwiki\Parsing\Parser($handler, $registry);
                foreach ($registry->getModes() as $mode) {
                    $parser->addMode($mode['mode'], $mode['obj']);
                }
            } else {
                // fallback for older versions
                $modes = p_get_parsermodes();
                $handler = new Doku_Handler();
                $parser = new \dokuwiki\Parsing\Parser($handler);
                foreach ($modes as $mode) {
                    $parser->addMode($mode['mode'], $mode['obj']);
                }
            }
            \dokuwiki\Extension\Event::createAndTrigger('PARSER_WIKITEXT_PREPROCESS', $markup);
            $parser->parse($markup);
            return $handler;
        } finally {
            $ID = $keep;
            $ACT = $keepAct;
        }
    }
}
