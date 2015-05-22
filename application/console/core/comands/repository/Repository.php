<?php
namespace comands\repository;

use init\weconsole\maker\Maker;
use init\weconsole\maker\MakerException;
use init\weconsole\WEConsole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Repository
 * @package comands\repository
 */
class Repository extends Command
{
    use WEConsole;
    /**
     * Comand configure
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('add:repository')
            ->setDescription('create repository')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'repository name'
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
                $path = WECON_BASEPATH_APP . 'repositories' . WECON_DS . ltrim($name, '/') .'.php';
                Maker::touch($path);
                $text = '<info>[OK] Reposity '.$name.' created<info>';
                $this->setFileContent($name, $path);
            }
            catch(MakerException $e)
            {
                $text = '<error>[ERROR] '.$e->getMessage().'<error>';
            }
        } else {
            $text = '<error>[ERROR] Repository name is required<error>';
        }

        $output->writeln($text);
    }

    /**
     * @param $repository_name
     * @param $file
     */
    private function setFileContent($repository_name, $file)
    {
        $class_name = $this->getClassName($repository_name);
        $repository_name = str_replace('/', '\\', $repository_name);
        $namespace = 'repositories\\' . $repository_name;

        $write = '<?php' . PHP_EOL;
        $write .= 'namespace ' . $namespace . ';' . PHP_EOL;
        $write .= 'use mvc\\Repository;' . PHP_EOL;
        //Coments Start
        $write .= '/**' . PHP_EOL;
        $write .= '* Class ' . $class_name . PHP_EOL;
        $write .= '* @package ' . $namespace . PHP_EOL;
        $write .= '*/' . PHP_EOL;
        //Coments End
        //Class start
        $write .= 'class ' . $class_name . ' extends Repository {' . PHP_EOL;
        $write .= PHP_EOL;
        $write .= PHP_EOL;
        $write .= '}';
        //Class end

        file_put_contents($file, $write);
    }
}