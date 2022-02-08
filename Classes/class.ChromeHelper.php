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


}