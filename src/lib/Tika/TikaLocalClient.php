<?php
/**
 * NovaeZSolrSearchExtraBundle.
 *
 * @package   NovaeZSolrSearchExtraBundle
 *
 * @author    Novactive <f.alexandre@novactive.com>
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaeZSolrSearchExtraBundle/blob/master/LICENSE
 */

namespace Novactive\EzSolrSearchExtra\Tika;

use Symfony\Component\Process\Process;

/**
 * Class TikaLocalClient.
 *
 * @package Novactive\EzSolrSearchExtra\Tika
 */
class TikaLocalClient implements TikaClientInterface
{
    /** @var string */
    protected $jar;

    /**
     * Client constructor.
     *
     * @param string $jar
     */
    public function __construct(string $jar)
    {
        $this->jar = $jar;
    }

    /**
     * @param $command
     *
     * @return string
     */
    protected function run($command)
    {
        $shellCommand = sprintf('java -Dpdfbox.fontcache=/tmp -jar %s %s', $this->jar, $command);

        $process = new Process($shellCommand);
        $process->setWorkingDirectory(__DIR__ . '/../../../');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    /**
     * {@inheritdoc}
     */
    public function getText($fileName): ?string
    {
        $file    = new \SplFileInfo($fileName);
        $command = sprintf('--text %s', $file->getRealPath());

        return $this->run($command);
    }
}
