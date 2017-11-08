<?php
namespace exface\AdminLteTemplate\Template\Elements;

class lteInputGroup extends ltePanel
{
    protected function buildHtmlCaption()
    {
        $caption = $this->getWidget()->getCaption();
        return $caption ? '<h3 class="page-header" style="font-size: 18px;">' . $caption . '</h3>' : '';
    }
}
?>
