<?php
include __DIR__ . "/../vendor/autoload.php";

use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Page;


class ChromeHelper
{
    private $browserFactory, $browser;

    public function __construct()
    {
        $this->browserFactory = new BrowserFactory();
        $this->createBrowser();

    }

    private function createBrowser()
    {
        $this->browser = $this->browserFactory->createBrowser(["headless" => false, "keepAlive" => true, 'windowSize' => ChromeWindowSize]);
    }

    /**
     * @return bool
     * @todo handle on error!
     */
    public function loginInstagram()
    {
        $page = $this->browser->createPage();
        $page->navigate(LoginUrl)->waitForNavigation();
        $page->addScriptTag(
            [
                "content" => file_get_contents(__DIR__ . "/../js/main.js")
            ])->waitForResponse();
        $page->evaluate("login('" . UserName . "','" . Password . "');")->waitForPageReload();
        return true;
    }

    private function getFollowData($operation, $user, $isJson)
    {
        if ($operation === "follower" || $operation === "following") {
            $page = $this->browser->createPage();
            $page->navigate("https://instagram.com/" . $user)->waitForNavigation(Page::NETWORK_IDLE);
            $page->addScriptTag([
                'content' => file_get_contents(__DIR__ . '/../js/jquery.js')
            ])->waitForResponse();
            $page->addScriptTag(
                [
                    "content" => file_get_contents(__DIR__ . "/../js/main.js")
                ])->waitForResponse();

            $page->keyboard()->typeRawKey('Tab')->typeRawKey('Tab')->typeRawKey('Tab')->typeRawKey('Tab')->typeRawKey('Tab');
            if ($operation === "follower") {
                $page->keyboard()->typeRawKey('Tab');
            }
            $page->keyboard()->typeRawKey("Enter");
            while (1) {
                $allDataAsJson = $page->evaluate("getJsonValue();")->getReturnValue();
                if ($allDataAsJson != "") {
                    echo "\nSonuc";
                    break;
                }
                echo "\nSleep";
                sleep(1);
            }

            if (SaveAllDataStorage) {
                if (MinifyStorage) {
                    file_put_contents(StorageDir . $user . "_" . $operation . ".json", $allDataAsJson);
                } else {
                    file_put_contents(StorageDir . $user . "_" . $operation . ".json", $allDataAsJson, JSON_PRETTY_PRINT);
                }

            }

            if ($isJson)
                return $allDataAsJson;
            return json_decode($allDataAsJson, true);
        }
        return null;
    }

    public function getFollowers($user, $isJson = false)
    {
        return $this->getFollowData("follower", $user, $isJson);
    }

    public function getFollowing($user, $isJson = false)
    {
        return $this->getFollowData("following", $user, $isJson);
    }


}