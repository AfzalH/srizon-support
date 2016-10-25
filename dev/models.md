## User

## Role

## Permission

## ProductCategory
fields: name:string:unique, icon:string, description:text

## Product
fields: name:string:unique, description:text, purchase_url:string:unique, icon:string, docs_url:string:unique, demo_url:string:unique, description_url:string:unique, paypro_id:integer:unique

## ReplyTemplate
fields: title:string, body:text

## ProductLink
fields: version:string:unique, url:string:unique, product_id:integer

## Order
fields: c_name:string, c_email:string, o_date:string, o_id:integer:unique, p_name:string, p_paypro_id:integer, product_id:foreign, status:string

## Ticket Category
fields: title:string

## Ticket
fields: title:string, slug:string, product_id, order_id, status:string, ticketcategory_id, user_id,

## TicketPost
fields: body:text, ticket_id, secrecy:string, user_id, status:string

## ActivityLog
fields: body:string, permalink:string

## ChangeLog
fields: table:string, col_name:string, old_val:text, new_val:text, user_id:integer

