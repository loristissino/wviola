# How to search assets archived with Wviola #

## Introduction ##

When assets are archived, they are put in a binder. You can search for an asset by looking of words associated to the asset itself or to its binder.

The query language is both powerful and easy to use. Here's just a brief introduction. You can read much more at the [Zend Lucene website](http://zendframework.com/manual/en/zend.search.lucene.query-language.html).

## Terminology ##

**Terms** are the things that make up a query. They can be Single Terms (single words), Phrases (group of words surrounded by double quotes), and Subqueries (queries surrounded by parentheses).

```
My dog Billy
```

will search for assets that have the words _my_ or _dog_ or _billy_ in the title, in the notes, etc.

```
"My dog Billy"
```

will search for assets that have exactly the phrase _My dog Billy_ in the title, in the notes, etc.

**Fields** are ways to perform specific queries looking only in some places, For example, with wviola you can search a word only in the title of an asset, or in the notes of a binder.

**Ranges** are ways to look for an asset specifying in which time interval the binder's event-date is.

```
date:[20090101 TO 20100531]
```

will look for assets contained in binders with an event date between Jan 1, 2009 and May 31, 2010, included (if you used curly brackets, the limits would be excluded).

## Boolean operators ##

**Boolean operators** allow terms to be combined through logic operators.

```
notes:"My dog" AND title:Billy
```

will search for assets with _my dog_ in the notes **and** _billy_ in the title, whereas

```
notes:"My dog" OR title:Billy
```

will search, of course, for assets with _my dog_ in the notes **or** _billy_ in the title.

You can also use the operator NOT like in

```
autumn and not billy
```

Boolean operators can also be expressed with operators like `&&` (and) `||` (or), and '!` (not).
You can also use `+` and `-`, like in

```
+autumn -billy
```