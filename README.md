# Chunk module for Silverstripe

Allows usage of small "snippets" or "fragments".
These are handles my modeladmin und can be used:

* in templates
```
$Chunk('Common.PhoneNumber')
```

* in php
```
Chunk::by_token('Common.PhoneNumber')
```

* as shortcode in HtmlEditor
```
[Chunk id=1]
or
[Chunk t="Common.PhoneNumber"]
```


