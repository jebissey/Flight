---
Title:       Bot- und Spider Sperre
Author:      FlightCMS
Date:        2024-01-24
Robots:      all
Featured:	 false
Tags:        MVC,Pattern,Controller,Home,Startseite,Landingpage
Logo:        /img/flightcms-dokumentation.svg
Description: FlightCMS sperrt alle nervigen Bots und Spider des Internets aus.
---
## Bots in htaccess blockieren ## {#htaccess-Bot-Sperre}

_FlightCMS_ ist mit einer Sperre ausgestattet und blockiert die nervigsten _Spider_ und _Bots_ des Internets.

	RewriteCond %{HTTP_USER_AGENT} InternetMeasurement [OR]
	RewriteCond %{HTTP_USER_AGENT} python-requests     [OR]
	RewriteCond %{HTTP_USER_AGENT} ALittle\ Client     [OR]
	RewriteCond %{HTTP_USER_AGENT} python-requests     [OR]
	RewriteCond %{HTTP_USER_AGENT} RepoLookoutBot      [OR]
	RewriteCond %{HTTP_USER_AGENT} Go-http-client      [OR]
	RewriteCond %{HTTP_USER_AGENT} SiteLockSpider      [OR]
	RewriteCond %{HTTP_USER_AGENT} DataForSeoBot       [OR]
	RewriteCond %{HTTP_USER_AGENT} ImagesiftBot        [OR]
	RewriteCond %{HTTP_USER_AGENT} SeekportBot         [OR]
	RewriteCond %{HTTP_USER_AGENT} seocompany          [OR]
	RewriteCond %{HTTP_USER_AGENT} GuzzleHttp          [OR]
	RewriteCond %{HTTP_USER_AGENT} Barkrowler          [OR]
	RewriteCond %{HTTP_USER_AGENT} SemrushBot          [OR]
	RewriteCond %{HTTP_USER_AGENT} AhrefsBot           [OR]
	RewriteCond %{HTTP_USER_AGENT} YandexBot           [OR]
	RewriteCond %{HTTP_USER_AGENT} SeznamBot           [OR]
	RewriteCond %{HTTP_USER_AGENT} PetalBot            [OR]
	RewriteCond %{HTTP_USER_AGENT} mj12bot             [OR]
	RewriteCond %{HTTP_USER_AGENT} ip\ bot             [OR]
	RewriteCond %{HTTP_USER_AGENT} DotBot              [OR]
	RewriteCond %{HTTP_USER_AGENT} mojeek              [OR]
	RewriteCond %{HTTP_USER_AGENT} YouBot              [OR]
	RewriteCond %{HTTP_USER_AGENT} RU_Bot              [OR]
	RewriteCond %{HTTP_USER_AGENT} wpbot               [OR]
	RewriteCond %{HTTP_USER_AGENT} CCBot
	RewriteRule .* - [R=403,L]
_Bot Beispiele_

Die Liste kann nach belieben individuell in der _htaccess_ erweitert werden.