<?php

namespace ComboStrap;

use ComboStrap\Web\Url;

class Robots
{

    const INDEX_DELAY = 'indexdelay';


    private static function debug_enabled(): bool
    {
        /**
         * We don't use the ?do=debug
         * https://www.dokuwiki.org/devel:debugging
         * Because in our rules, only url with the id are indexed
         * and therefore the header would be useless
         */
        /**
         * If the debug is allowed and the x-debug header is sent
         * we sent back the X-Debug-Robots-NoIndex-Reason headers
         */
        global $conf;
        return ($conf['allowdebug'] === 1)
            && isset($_SERVER['HTTP_X_DEBUG'])
            && $_SERVER['HTTP_X_DEBUG'] === '1';
    }

    /**
     * @throws ExceptionNotEnabled - if the page can be indexed
     */
    public static function canBeIndexedAndGetFollowValue(MarkupPath $page, ExecutionContext $executionContext): string
    {

        $DEBUG_ENABLED = self::debug_enabled();

        $action = $executionContext->getExecutingAction();
        if ($action !== ExecutionContext::SHOW_ACTION) {
            if ($DEBUG_ENABLED) {
                self::add_robots_headers("Action ($action) should not be indexed");
            }
            return "nofollow";
        }

        /**
         * No indexing for slot page
         */
        if ($page->isSlot()) {
            if ($DEBUG_ENABLED) {
                self::add_robots_headers("A slot can not be indexed");
            }
            return "follow";
        }

        /**
         * Resolution of the Google Search Console Issue
         * "Alternative page with proper canonical tag"
         * when Google crawls URl with functional Query String such as
         *
         * https://datacadamia.com/lang/java/comment?redirectId=java:comment&redirectOrigin=canonical
         * https://datacadamia.com/os/windows/pathext?referer=https://gerardnico.com/os/windows/pathext
         *
         * TODO: Ultimately, we should use a script that returns only the good url
         *   doing a redirect with a query to the resource is not Search Engine friendly
         */
        $queryProperties = Url::createFromGetOrPostGlobalVariable()->getQueryProperties();
        foreach ($queryProperties as $key => $value) {
            if ($key !== DokuwikiId::DOKUWIKI_ID_ATTRIBUTE) {
                if ($DEBUG_ENABLED) {
                    self::add_robots_headers("The query has more than the id property. The property $key was found.");
                }
                // follow but no index as we return a value
                return "follow";
            }
        }

        if ($page->isLowQualityPage() && LowQualityPage::isProtectionEnabled()) {
            if (LowQualityPage::getLowQualityProtectionMode() !== PageProtection::CONF_VALUE_ACL) {
                if ($DEBUG_ENABLED) {
                    self::add_robots_headers("Low quality page");
                }
                return "follow";
            }
        }
        if ($page->isLatePublication() && PagePublicationDate::isLatePublicationProtectionEnabled()) {
            if ($DEBUG_ENABLED) {
                self::add_robots_headers("Late publication");
            }
            if (PagePublicationDate::getLatePublicationProtectionMode() == PageProtection::CONF_VALUE_ACL) {
                return "nofollow";
            } else {
                return "follow";
            }
        }

        if ($DEBUG_ENABLED) {
            self::add_robots_headers("Page can be indexed");
        }
        throw new ExceptionNotEnabled();
    }

    private static function add_robots_headers(string $reason): void
    {
        header("X-Debug-Robots-NoIndex-Reason: $reason");
    }
}
