namespace Acme\Bundle\AcmeBundle\Twig\Extension;
 
class MyfilterExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'myfilter' => new \Twig_Filter_Method($this, 'doSomething')
        );
    }
 
    public function doSomething($value)
    {
        return 'transformated-' . $value;
    }
 
    public function getName()
    {
        return 'myfilter_extension';
    }
 
} 