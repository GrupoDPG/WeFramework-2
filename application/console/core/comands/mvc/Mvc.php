<?php
namespace comands\mvc;
use comands\controller\Controller;
use comands\model\Model;
use comands\view\View;
use init\weconsole\maker\MakerException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use init\weconsole\WEConsole;
/**
 * Class Mvc
 * @package comands\mvc
 */
class Mvc extends Command
{
    use WEConsole;
    /**
     * Comand configure
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('add:mvc')
            ->setDescription('create mvc struct')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Set the name for Model, View and Controller'
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
        if($name)
        {
            $this->executeMake($name, $input, $output);
        }
        else
        {
            $this->executeSteps($input, $output);
        }
    }

    /**
     * @param $name
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function executeMake($name, InputInterface $input, OutputInterface $output)
    {
        try
        {
            $this->make($name, $input, $output);
            $output->writeln('<info>[OK] Mvc created</info>');
        }
        catch(MakerException $m)
        {
            $output->writeln($m->getMessage());
            return;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function executeSteps(InputInterface $input, OutputInterface $output)
    {
        try
        {
            $this->makeSteps($input, $output);
            //Output
            $output->writeln('<info>[OK] Mvc created</info>');
        }
        catch(MvcException $e)
        {
            $output->writeln($e->getMessage());
            return;
        }
        catch(MakerException $m)
        {
            $output->writeln($m->getMessage());
            return;
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function makeSteps(InputInterface $input, OutputInterface $output)
    {
        $model = $this->model($input, $output);
        $view = $this->view($input, $output);
        $controller = $this->controller($input, $output);
        //Makers
        $mk_model = new Model();
        $mk_view = new View();
        $mk_controller = new Controller();
        //Make files
        $mk_model->make($model);
        $mk_view->make($view);
        $mk_controller->make($controller);
    }

    /**
     * @param $name
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function make($name, InputInterface $input, OutputInterface $output)
    {
        //Makers
        $mk_model = new Model();
        $mk_view = new View();
        $mk_controller = new Controller();
        //Make files
        $mk_model->make($name);
        $mk_view->make($name);
        $mk_controller->make($name);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws MvcException
     */
    private function controller(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the controller name: ');
        $controller = $helper->ask($input, $output, $question);
        if($controller)
            return $controller;
        else
            throw new MvcException('Controller name can not be empty');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws MvcException
     */
    private function model(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the model name: ');
        $model = $helper->ask($input, $output, $question);
        if($model)
            return $model;
        else
            throw new MvcException('Model name can not be empty');
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws MvcException
     */
    private function view(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the view name: ');
        $view = $helper->ask($input, $output, $question);
        if($view)
            return $view;
        else
            throw new MvcException('View name can not be empty');
    }

}