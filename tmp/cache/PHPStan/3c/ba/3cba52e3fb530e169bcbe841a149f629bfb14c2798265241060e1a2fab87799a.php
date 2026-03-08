<?php declare(strict_types = 1);

// odsl-/media/talha/225cc24f-0576-4344-ad66-f11a054af19c2/laravel/blog/app/Models/Category.php-PHPStan\BetterReflection\Reflection\ReflectionClass-App\Models\Category
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.3.6-e480ecc601fc458f05ec049dfdccc61cef754a19d7e63496e4e3de78549e0438',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'App\\Models\\Category',
        'filename' => '/media/talha/225cc24f-0576-4344-ad66-f11a054af19c2/laravel/blog/app/Models/Category.php',
      ),
    ),
    'namespace' => 'App\\Models',
    'name' => 'App\\Models\\Category',
    'shortName' => 'Category',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => '/**
 * @property-read \\App\\Models\\User|null $user
 * @property-read \\Illuminate\\Database\\Eloquent\\Collection<int, \\App\\Models\\Post> $posts
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 15,
    'endLine' => 36,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => 'Illuminate\\Database\\Eloquent\\Model',
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
      0 => 'Illuminate\\Database\\Eloquent\\Factories\\HasFactory',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'fillable' => 
      array (
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'name' => 'fillable',
        'modifiers' => 2,
        'type' => NULL,
        'default' => 
        array (
          'code' => '[\'category_name\']',
          'attributes' => 
          array (
            'startLine' => 24,
            'endLine' => 26,
            'startTokenPos' => 59,
            'startFilePos' => 556,
            'endTokenPos' => 64,
            'endFilePos' => 587,
          ),
        ),
        'docComment' => '/**
 *
 * @var list<string>
 */',
        'attributes' => 
        array (
        ),
        'startLine' => 24,
        'endLine' => 26,
        'startColumn' => 5,
        'endColumn' => 6,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      'posts' => 
      array (
        'name' => 'posts',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Illuminate\\Database\\Eloquent\\Relations\\HasMany',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * 
 * @return HasMany<Post, $this>
 */',
        'startLine' => 32,
        'endLine' => 35,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'App\\Models',
        'declaringClassName' => 'App\\Models\\Category',
        'implementingClassName' => 'App\\Models\\Category',
        'currentClassName' => 'App\\Models\\Category',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));