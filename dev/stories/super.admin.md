# Super Admin Related Stories	

`SA = Super Admin`

## The first user (user with id = 1) created with installation migration will be the SA.
**status:** done

## SA should be able to go to a restricted screen and see some restricted menu items and perform action on those menu items
**status:** done
note for dev: anything placed under the super middleware group in routes.php will be accessible only by the SA
 
## SA should be able to manage user accounts
**status:** done

## SA should be able to manage user roles
**status:** done

## SA should be able to manage permissions
**status:** done

## SA should be able to assign/revoke user-role relations
**status:** done

## SA should be able to assign/revoke role-permission relations
**status:** done

## SA should be able to manage *product category*
**status:** concept

**menu items:** product category

**actions:** basic CRUD, attach/detach category to/from products

**screens:** basic CRUD screens

**relations:** many-to-many with product

## SA should be able to manage *products*
**status:** concept

**menu items:** Product

**actions:** product listing, product creation, product deletion, 
		product update, add/remove product download links, edit product download links, edit reply template text, 
		attache/detach reply templates

**screens:** Product Home, Individual Product, Product Creation/Update Form

**relations:** one-to-many with product download links, many-to-many with reply templates, many-to-many with product category

## SA should be able to manage *Reply Templates*
**status:** concept

**menu items:** Reply Templates

**actions:** listing, creation, deletion, edit, attach/detach with product

**screens:** template listing, individual template, product edit/create form

**relations:** many to many with products

