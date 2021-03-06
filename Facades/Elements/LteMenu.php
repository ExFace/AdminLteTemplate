<?php
namespace exface\AdminLTEFacade\Facades\Elements;

use exface\Core\Widgets\Menu;

/**
 * 
 * @method Menu getWidget()
 * 
 * @author Andrej Kabachnik
 *
 */
class LteMenu extends lteAbstractElement 
{
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildHtml()
     */
    public function buildHtml()
    {  
        if ($caption = $this->getWidget()->getCaption()){
            $header = <<<HTML
        <li class="header">
            {$caption}
        </li>
HTML;
        }
        
        return <<<HTML
<ul id="{$this->getId()}" class="exf-menu">
    {$header}
    {$this->buildHtmlButtons()}
</ul>
HTML;
    }
    
    /**
     * Renders buttons as <li> elements
     * 
     * @return string
     */
    public function buildHtmlButtons()
    {
        $buttons_html = '';
        $last_parent = null;
        /* @var $b \exface\Core\Widgets\Button */
        foreach ($this->getWidget()->getButtons() as $b) {
            if (is_null($last_parent)){
                $last_parent = $b->getParent();
            }
            
            // Create a menu entry: a link for actions or a separator for empty buttons
            if (! $b->getCaption() && ! $b->getAction()){
                $buttons_html .= '<li role="separator" class="divider"></li>';
            } else {
                if ($b->getParent() !== $last_parent){
                    $buttons_html .= '<li role="separator" class="divider"></li>';
                    $last_parent = $b->getParent();
                }
                // If there is a caption or an action, create a menu entry
                $disabled_class = $b->isDisabled() ? ' disabled' : '';
                $buttons_html .= '
    					<li class="' . $disabled_class . '">
    						<a id="' . $this->getFacade()->getElement($b)->getId() . '" data-target="#"' . ($b->isDisabled() ? '' : ' onclick="' . $this->getFacade()->getElement($b)->buildJsClickFunctionName(). '();"') . '>
    							<i class="' . $this->buildCssIconClass($b->getIcon()) . '"></i>' . $b->getCaption() . '
    						</a>
    					</li>';
            }
        }
        return $buttons_html;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \exface\Core\Facades\AbstractAjaxFacade\Elements\AbstractJqueryElement::buildJs()
     */
    public function buildJs()
    {
        $buttons_js = '';
        foreach ($this->getWidget()->getButtons() as $btn){
            $buttons_js .= $this->getFacade()->getElement($btn)->buildJs();
        }
        return $buttons_js;
    }
}