<?php namespace Tests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class TestBase extends Command
{
    /**
     * Nome do test
     * @var string
     */
    //protected static $defaultName = 'app:create-user';

    /**
     * Descricao do test
     * @var string
     */
    protected $description = '';

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setDescription($this->description);
    }

    /**
     * Executar comando.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->handle();
    }

    /**
     * Execuar teste.
     */
    abstract protected function handle();

    /**
     * Enviar para o output uma info.
     */
    protected function info($str)
    {
        $this->output->writeln($str);
    }

    /**
     * Fazer pergunta para o console.
     */
    protected function ask($question, $default = null)
    {
        $helper = $this->getHelper('question');

        $question = new Question($question . ': ', $default);

        return $helper->ask($this->input, $this->output, $question);        
    }
}
