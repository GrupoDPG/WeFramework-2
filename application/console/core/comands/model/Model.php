<?php
namespace comands\model;

use init\weconsole\maker\Maker;
use init\weconsole\maker\MakerException;
use init\weconsole\WEConsole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Model
 * @package comands\model
 */
class Model extends Command
{
    use WEConsole;
    /**
     * Comand configure
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('add:model')
            ->setDescription('create model file')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'model name'
            )
        ;
    }

    /**
     * Comand execute
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected  function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if ($name) {
            try
            {
                $this->make($name);
                $text = '<info>[OK] Model '.$name.' created<info>';
            }
            catch(MakerException $e)
            {
                $text = '<error>[ERROR] '.$e->getMessage().'<error>';
            }
        } else {
            $text = '<error>[ERROR] Model name is required<error>';
        }

        $output->writeln($text);
    }

    /**
     * @param $name
     */
    public function make($name)
    {
        $class_name = ucfirst($this->getClassName($name)) . 'Model';
        $path = WECON_BASEPATH_APP . 'package' . WECON_DS . ltrim($name, '/') . WECON_DS . 'model' . WECON_DS . $class_name .'.php';
        Maker::touch($path);
        $this->setFileContent($name, $path);
    }

    /**
     * @param $name
     * @param $file
     */
    private function setFileContent($name, $file)
    {
        $class_name = ucfirst($this->getClassName($name)) . 'Model';
        $name = str_replace('/', '\\', $name);
        $namespace = $name . '\\model';

        $write = '<?php' . PHP_EOL;
        $write .= 'namespace ' . $namespace . ';' . PHP_EOL;
        $write .= 'use mvc\\Model;' . PHP_EOL;
        //Coments Start
        $write .= '/**' . PHP_EOL;
        $write .= '* Class ' . $class_name . PHP_EOL;
        $write .= '* @package ' . $namespace . PHP_EOL;
        $write .= '*/' . PHP_EOL;
        //Coments End
        //Class start
        $write .= 'class ' . $class_name . ' extends Model {' . PHP_EOL;
        $write .= PHP_EOL;
        $write .= '}';
        //Class end

        file_put_contents($file, $write);
    }
}