<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\Messenger;

use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Project\Shared\Domain\Bus\Command\CommandValidate;
use Project\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Project\Shared\Infrastructure\Bus\CommandNotRegistered;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    private MessageBus $bus;

    public function __construct(iterable $commandHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(CallableFirstParameterExtractor::forCallables($commandHandlers))
            ),
        ]);
    }

    public function dispatch(CommandInterface $command): mixed
    {
        try {
            if ($command instanceof CommandValidate) {
                $command->validate();
            }

            return $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegistered('Command ' . get_class($command) .  ' not registered.');
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        } // catch (\Exception $ex) {
        //     dd($ex);
        // }
    }
}