<?php
namespace comands\view;

use init\weconsole\maker\Maker;
use init\weconsole\maker\MakerException;
use init\weconsole\WEConsole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class View
 * @package comands\view
 */
class View extends Command
{
    use WEConsole;
    /**
     * Comand configure
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('add:view')
            ->setDescription('create view file')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'view name'
            )
        ;
    }

    /**
     * Comand execute
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if ($name) {
            try
            {
                $this->make($name);
                $text = '<info>[OK] View '.$name.' created<info>';
            }
            catch(MakerException $e)
            {
                $text = '<error>[ERROR] '.$e->getMessage().'<error>';
            }
        } else {
            $text = '<error>[ERROR] View name is required<error>';
        }

        $output->writeln($text);
    }

    /**
     * @param $name
     */
    public function make($name)
    {
        $ds = WECON_DS;
        $view_name = $this->getViewName($name);
        $view_path = $this->getViewPath($name);
        if(!empty($view_path))
            $view_path = $ds . str_replace('/', $ds, $view_path) . $ds;
        else
            $view_path = $ds;

        $path = WECON_BASEPATH_LAYOUT . 'themes' . $view_path . 'pages'. $ds . $view_name . $ds . $view_name . '.php';
        Maker::touch($path);
        $this->setFileContent($path);
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getViewName($name)
    {
        if(strpos($name, '/') !== false)
        {
            $ex = explode('/', $name);
            $view = $ex[count($ex) - 1];
            unset($ex[count($ex) - 1]);
        }
        else
            $view = $name;

        return $view;
    }

    /**
     * @param $name
     * @return string
     */
    private function getViewPath($name)
    {
        if(strpos($name, '/') !== false)
        {
            $ex = explode('/', $name);
            unset($ex[count($ex) - 1]);
            $path = implode('/', $ex);
        }
        else
            $path = '';

        return $path;
    }

    /**
     * @param $file
     */
    private function setFileContent($file)
    {
        $write = '<h2>New View created!</h2>';
        file_put_contents($file, $write);
    }
}