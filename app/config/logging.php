<?php

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\ProcessorInterface;
use Monolog\LogRecord;

class ExtraInfoProcessor implements ProcessorInterface 
{
    private array $info = [];

    public function addInfo(array $data): void 
    {
        $this->info = array_merge($this->info, $data);
    }

    public function __invoke(LogRecord $record): LogRecord 
    {
        $record['extra'] = array_merge($record['extra'], $this->info);
        return $record;
    }
}

function configureLogger(): Logger 
{
    $loggingFile = $_SERVER['logging_file'] ?? 'D:\xampp\htdocs/application.log';
    $loggingMaxFiles = (int) ($_SERVER['logging_max_files'] ?? 2);
    $loggingLevel = $_SERVER['logging_level'] ?? 'debug';

    $logger = new Logger('general');
    $infoProcessor = new ExtraInfoProcessor();
    $logger->pushProcessor($infoProcessor);
    ErrorHandler::register($logger);

    $jsonFormatter = new JsonFormatter();
    $jsonFormatter->includeStacktraces(true);

    $fileHandler = new RotatingFileHandler($loggingFile, $loggingMaxFiles, $loggingLevel);
    $fileHandler->setFormatter($jsonFormatter);
    $logger->pushHandler($fileHandler);

    if ($_SERVER['APP_DEBUG'] == '1') 
    {
        $lineFormatter = new LineFormatter();
        $lineFormatter->includeStacktraces(true);

        $streamHandler = new StreamHandler('php://stderr', $loggingLevel);
        $streamHandler->setFormatter($lineFormatter);
        $logger->pushHandler($streamHandler);
    }

    return $logger;
}

function getLogger(): Logger 
{
    static $logger;
    if (!$logger) 
    {
        $logger = configureLogger();
    }
    return $logger;
}

function logExtraInfo(array $data): void 
{
    $logger = getLogger();
    $logger->getProcessors()[0]->addInfo($data);
}

function resetLogger(): void 
{
    $logger = getLogger();
    foreach ($logger->getHandlers() as $handler) 
    {
        if ($handler instanceof RotatingFileHandler) 
        {
            $handler->close();
        }
    }
}