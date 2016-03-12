<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Propel\PropelBundle\PropelBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new APY\BreadcrumbTrailBundle\APYBreadcrumbTrailBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new liuggio\ExcelBundle\liuggioExcelBundle(),
            new Visualnet\SessionBundle\VisualnetSessionBundle(),
            new Visualnet\UserBundle\VisualnetUserBundle(),
            new Visualnet\UtilsBundle\VisualnetUtilsBundle(),
            new Visualnet\MenuBundle\MenuBundle(),
            new Visualnet\LogBundle\VisualnetLogBundle(),
            new Visualnet\VisualRecruiter\TranslateBundle\TranslateBundle(),
            new Visualnet\VisualRecruiter\UserBundle\UserBundle(),
            new Visualnet\VisualRecruiter\AdminBundle\AdminBundle(),
            new Visualnet\VisualRecruiter\FrontendBundle\FrontendBundle(),
            new Visualnet\VisualRecruiter\UtilsBundle\UtilsBundle(),
            new Visualnet\VisualRecruiter\QuestionBundle\QuestionBundle(),
            new Visualnet\VisualRecruiter\FormBundle\FormBundle(),
            new Visualnet\VisualRecruiter\RecruitmentBundle\RecruitmentBundle(),
            new Visualnet\VisualRecruiter\ExportBundle\ExportBundle(),
            new Visualnet\VisualRecruiter\StatisticsBundle\StatisticsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
