<?php
namespace Hubrix\Core\Events;

use Illuminate\Events\Dispatcher;
use ReflectionClass;

class EventRegistrar
{
    /**
     * The event dispatcher instance.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new event registrar instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Register all events and listeners found in the specified directories.
     *
     * @param array $directories
     * @return void
     */
    public function registerEventsAndListeners(array $directories): void
    {
        foreach ($directories as $directory) {
            $this->registerDirectory($directory);
        }
    }

    /**
     * Register events and listeners from a specific directory.
     *
     * @param string $directory
     * @return void
     */
    protected function registerDirectory(string $directory): void
    {
        $eventFiles = glob($directory . '/Events/*.php');
        $listenerFiles = glob($directory . '/Listeners/*.php');

        foreach ($eventFiles as $eventFile) {
            $eventClass = $this->getClassNameFromFile($eventFile);
            $this->registerEventListeners($eventClass, $listenerFiles);
        }
    }

    /**
     * Register listeners for a specific event.
     *
     * @param string $eventClass
     * @param array $listenerFiles
     * @return void
     */
    protected function registerEventListeners(string $eventClass, array $listenerFiles): void
    {
        foreach ($listenerFiles as $listenerFile) {
            $listenerClass = $this->getClassNameFromFile($listenerFile);

            if ($this->isListenerForEvent($listenerClass, $eventClass)) {
                $this->dispatcher->listen($eventClass, [$listenerClass, 'handle']);
            }
        }
    }

    /**
     * Determine if the listener is for the given event.
     *
     * @param string $listenerClass
     * @param string $eventClass
     * @return bool
     */
    protected function isListenerForEvent(string $listenerClass, string $eventClass): bool
    {
        $reflection = new ReflectionClass($listenerClass);

        return $reflection->hasMethod('handle') &&
            $reflection->getMethod('handle')->getParameters()[0]->getClass()->getName() === $eventClass;
    }

    /**
     * Get the fully qualified class name from the file.
     *
     * @param string $file
     * @return string
     */
    protected function getClassNameFromFile(string $file): string
    {
        $content = file_get_contents($file);
        $namespace = '';
        $class = '';

        if (preg_match('/namespace\s+(.+?);/', $content, $matches)) {
            $namespace = $matches[1] . '\\';
        }

        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $class = $matches[1];
        }

        return $namespace . $class;
    }
}
