<?php


namespace Hekmatinasser\Verta\Traits;


trait Translator
{
    /**
     * List of custom localized messages.
     *
     * @var array
     */
    public static $messages = array();

    /**
     * List of custom localized messages.
     *
     * @var array
     */
    public static $locale;

    /**
     * Reset the format used to the default when type juggling a Verta instance to a string
     */
    public static function resetLocale()
    {
        static::setStringFormat(static::DEFAULT_LOCALE);
    }

    /**
     * Set the default locale
     *
     * @param string $locale
     */
    public static function setLocale($locale)
    {
        if($messages = static::loadMessages($locale)) {
            static::$locale = $locale;
        } 
        return $messages;
    }

    /**
     * Get the default locale
     *
     * @param string $locale
     */
    public static function getLocale()
    {
        return static::$locale ?: static::DEFAULT_LOCALE;
    }

    /**
     * Return a singleton instance of Translator.
     *
     * @param string|null $locale optional initial locale ("fa" -  by default)
     *
     * @return bool
     */
    public static function loadMessages($locale = null)
    {
        if ($messages = static::getMessages($locale)) {
            static::$messages = $messages;
            return true;
        }

        return false;
    }


    /**
     * Set messages of a locale and take file first if present.
     *
     * @param string $locale
     *
     * @return mixed
     */
    public static function getMessages($locale = null)
    {
        if (file_exists($filename = dirname(__DIR__).'/Lang/'.($locale ?: static::getLocale()).'.php')) {
            return require $filename;
        }
        return false;
    }


    /**
     * Set messages of a locale and take file first if present.
     *
     * @param string $locale
     * @param array $messages
     *
     * @return $this
     */
    public function setMessages($locale, $messages)
    {
        if (static::loadMessages($locale)) {
            static::$messages = array_merge(static::$messages, $messages);
        }
        static::$messages = $messages;
    }
}