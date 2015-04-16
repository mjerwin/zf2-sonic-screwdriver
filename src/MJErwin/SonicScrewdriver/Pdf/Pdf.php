<?php

namespace MJErwin\SonicScrewdriver\Pdf;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class Pdf extends \DOMPDF
{
    function __construct()
    {
        define('DOMPDF_ENABLE_AUTOLOAD', false);

        require_once '../../../../../../dompdf/dompdf/dompdf_config.inc.php';

        parent::__construct();
    }
}