<?php
/**
 *
 */
namespace HelpTooltips\View\Helper\HelpTooltips;

class HelpTooltips extends \Laminas\View\Helper\AbstractHelper
{
    protected $helpTooltipsConfig;
    protected $session;

    /**
     * Constructor.
     *
     * @param $config
     * @param \VuFind\Search\Memory $memory
     * @param $sessionManager
     */
    public function __construct($config, \VuFind\Search\Memory $memory, $sessionManager)
    {
        $this->helpTooltipsConfig = parse_ini_file(realpath(getenv('VUFIND_LOCAL_DIR') . '/config/vufind/HelpTooltips.ini'), true);
        $this->sessionManager = $sessionManager;
        $this->session = new \Laminas\Session\Container(
            'HelpTooltips', $sessionManager
        );
    }

    /**
     * Get configuration for HelpTooltip.
     * @param $context String if present the config is filtered by this string
     * @return array|false
     */
    public function getHelpTooltipsConfig ($context = 'all') {
        if ($context != 'all') {
            $helpTooltips = [];
            foreach ($this->helpTooltipsConfig as $helpTooltip) {
                if ($helpTooltip['context'] == $context) {
                    $helpTooltips[] = $helpTooltip;
                }
            }
            return $helpTooltips;
        } else {
            return $this->helpTooltipsConfig;
        }
    }

    /**
     * Get current request URI.
     *
     * @return mixed
     */
    public function getHelpFormAction () {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Check the 'showHelp' and 'hideHelp' post parameters and set 'showHelp' variable accordingly.
     *
     * @return bool indicating whether the help should be shown
     */
    public function showHelp () {
        if (isset($_POST['showHelp']) && $_POST['showHelp']) {
            $this->session->showHelp = true;
        } else if (isset($_POST['hideHelp']) && $_POST['hideHelp']) {
            $this->session->showHelp = false;
        }

        return $this->session->showHelp;
    }
}
