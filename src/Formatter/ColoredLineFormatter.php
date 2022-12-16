<?php

namespace Regho\Monolog\Formatter;

use Monolog\LogRecord;
use Regho\Monolog\Formatter\ColorSchemes\ColorSchemeInterface;
use Regho\Monolog\Formatter\ColorSchemes\DefaultScheme;
use \Monolog\Formatter\LineFormatter;

/**
 * A Colored Line Formatter for Monolog
 */
class ColoredLineFormatter extends LineFormatter {
    /**
     * The Color Scheme to use
     * @var ColorSchemeInterface
     */
    private ColorSchemeInterface $colorScheme;

    /**
     * @param ColorSchemeInterface|null $colorScheme
     * @param null $format The format of the message
     * @param null $dateFormat The format of the timestamp: one supported by DateTime::format
     * @param bool $allowInlineLineBreaks Whether to allow inline line breaks in log entries
     * @param bool $ignoreEmptyContextAndExtra
     */
    public function __construct(?ColorSchemeInterface $colorScheme = null, $format = null, $dateFormat = null, bool $allowInlineLineBreaks = false, bool $ignoreEmptyContextAndExtra = false) {
        // Store the Color Scheme
        if (!$colorScheme) {
            $this->colorScheme = new DefaultScheme();
        } else {
            $this->colorScheme = $colorScheme;
        }

        // Call Parent Constructor
        parent::__construct($format, $dateFormat, $allowInlineLineBreaks, $ignoreEmptyContextAndExtra);
    }

    /**
     * Gets The Color Scheme
     * @return ColorSchemeInterface
     */
    public function getColorScheme(): ColorSchemeInterface {
        return $this->colorScheme;
    }

    /**
     * Sets The Color Scheme
     * @param ColorSchemeInterface $colorScheme
     */
    public function setColorScheme(ColorSchemeInterface $colorScheme) {
        $this->colorScheme = $colorScheme;
    }

    /**
     * {@inheritdoc}
     */
    public function format(LogRecord $record): string {
        // Get the Color Scheme
        $colorScheme = $this->getColorScheme();

        // Let the parent class to the formatting, yet wrap it in the color linked to the level
        return $colorScheme->getColorizeString($record->level->value) . trim(parent::format($record)) . $colorScheme->getResetString() . "\n";
    }
}
