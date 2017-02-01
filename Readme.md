ProcessGraphQL
==============

A GraphQL for ProcessWire.

The module seamlessly integrates to your [ProcessWire][pw] web app and allowa you to
serve the GraphQL api of your existing app. You don't need to apply changes to
your content or it's structure. 

Here is an example of ProcessGraphQL in action after installing it to 
[skyscrapers][pw-skyscrapers] profile.

![ProcessGraphQL Simple Query][img-query]

ProcessGraphQL supports filtering via [ProcessWire Selectors][pw-selectors].

![ProcessGraphQL Supports ProcessWire Selectors][img-filtering]

ProcessGraphQL supports complex fields like FieldtypeImage or FieldtypePage.

![ProcessGraphQL Supporting FieldtypeImage and FieldtypePage][img-fieldtypes]

Documentation for your api is easily accessible via GraphiQL interface.
![ProcessGraphQL Schema Documentation][img-documentation]

## Requirements
- ProcessWire version 3.x.x and up. There are no plans to support the older versions. 
- PHP version 5.4 and up.

> It would be very helpful if you open an issue when encounter errors regarding
> environment incompatibilities.

## Installation
To install the module, place the contents of this directory into your `/site/modules/`
directory and go to `Setup -> Modules` in your ProcessWire admin panel and click
__Refresh__ button. You should see the ProcessGraphQL module that you can install
by clicking the __Install__ button next to it.

After you installed the ProcessGraphQL, you can go to `Setup -> GraphQL` in your
admin panel and you will see the GraphiQL where you can perform queries to your
GraphQL api.

## Configuration
There are some options to configure the ProcessGraphQL module.
#### MaxLimit
The MaxLimit option allows you to set the ProcessWire's [limit][pw-api-selectors-limit] slelector. So that 
client is not able to more than that. While client can set values less than MaxLimit, if
she requests more it will be overwritten and set to MaxLimit. Default is 100.

#### Legal Templates
Legal Templates are the templates that can be fetched via ProcessGraphQL. You have explicitly
tell ProcessGraphQL which templates you wish to declare as public api.

Please bear in mind that making a template legal does not neccessarily mean it is
open to everyone. The user permissions still apply. If you selected template __user__
as legal but the requesting user does not have permissions to view it. She won't be
able to retrieve that data.

## API
If you wish to expose your GraphQL api, you can do so by calling a single method on
ProcessGraphQL module in your template file. Here is what it might look like
```php
<?php

// /site/templates/graphql.php

echo $modules->get('ProcessGraphQL')->executeGraphQL();
```

You can also expose the GraphiQL from within your template. Here is how you can do that.
```php
<?php

// /site/templates/graphiql.php

echo $modules->get('ProcessGraphQL')->executeGraphiQL();
```
> Please note that GraphiQL is a full web page. Meaning it includes `header`,
> `title` and so on. Depending on your site configuration you might want to
> disable `$config->prependTemplateFile` and/or `$config->appendTemplateFile`
> for the template that exposes GraphiQL.

By default the GraphiQL is pointed to your admin GraphQL server, which is 
`/processwire/setup/graphql/`. You might want to change that because ProcessWire
will not allow guest users to access that url. You can point GraphiQL to whatever adress
you want by a property `GraphQLServerUrl`. ProcessGraphQL will respect that property
when exposing GraphiQL.
Here is how you might do this in your template file.
```php
// /site/templates/graphiql.php

$ProcessGraphQL = $modules->get('ProcessGraphQL');
$ProcessGraphQL->GraphQLServerUrl = '/graphql/';
echo $ProcessGraphQL->executeGraphiQL();
```

### Limitations
At this stage the module only supports the `Query` schema. There is no `Mutation` for now.
It will be implemented as soon as people will request this feature.

### Permissions
ProcessGraphQL respects the ProcessWire permissions on template level. It basicly does that
via `$user->hasPermission('page-view', $template)`. So as long as the client does not have
that permission she won't be able to query it.

## License
[MIT](https://github.com/dadish/ProcessGraphQL/blob/master/LICENSE)

[graphql]: http://graphql.org/
[graphiql]: https://github.com/graphql/graphiql/
[pw]: https://processwire.com
[pw-skyscrapers]: http://demo.processwire.com/
[pw-selectors]: https://processwire.com/api/selectors/
[pw-api-selectors-limit]: https://processwire.com/api/selectors#limit
[img-query]: https://raw.githubusercontent.com/dadish/ProcessGraphQL/master/imgs/ProcessGraphQL-Query.gif
[img-filtering]: https://raw.githubusercontent.com/dadish/ProcessGraphQL/master/imgs/ProcessGraphQL-Filtering.gif
[img-fieldtypes]: https://raw.githubusercontent.com/dadish/ProcessGraphQL/master/imgs/ProcessGraphQL-Fieldtypes.gif
[img-documentation]: https://raw.githubusercontent.com/dadish/ProcessGraphQL/master/imgs/ProcessGraphQL-Documentation.gif