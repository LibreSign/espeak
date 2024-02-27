# PHP wrapper for eSpeak NG

## About eSpeak NG

eSpeak is a free and open-source, cross-platform, compact, software speech synthesizer.

## About eSpeak NG in this project

Thinking about accessibility for visually impaired users when they need to fill out the contact form. We decided to implement the eSpeak NG library, which has the functionality to speak captcha characters.

## Example

```php
header('Content-Type: audio/wav');
header('Content-Disposition: inline;filename=captcha.wave');

echo (new Espeak())
        ->setOption('stdout')
        ->setOption('s', '110')
        ->setOption('v', (new Espeak())->getVoiceCode($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        ->execute('Hello World');
```

## Library Documentation

https://github.com/espeak-ng/espeak-ng