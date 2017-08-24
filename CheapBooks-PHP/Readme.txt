
------------------description-----------------------------------------------------------------------------------------
To set-up a database for www.cheapbooks.com, which sales books on the web
(much like www.amazon.com). A requirements analysis that was conducted has identified a number
things about the operations and goals of CheapBooks. Each book sold by CheapBooks has a title, a
price, a year of issue, a publisher, and a unique ISBN. It is written by one or more authors, but, of
course, each author may have written multiple books. Although not available to customers,
CheapBooks has information about each author, which may include name, address, and phone number.
Each book is stocked in book warehouses and CheapBooks wants to keep track how many copies of a
book each warehouse has, in order to check it's availability and complete the customer orders. Each
warehouse has a Code, a name, an address, and a phone number. When a customer starts a session with
CheapBooks through its web site, she is assigned an empty shopping basket so that she can make
multiple purchases each time. The customer session is then to select books and insert them into the
shopping basket. The shopping basket may contain multiple copies of multiple books. Note that, at any
time you may have multiple customers buying books and a particular customer may have used multiple
shopping baskets. At checkout, the total price of the customer's shopping basket is calculated and the
customer is charged (assume that shipping cost is zero). At checkout, each warehouse involved in the
purchase is received a single shipping order that contains the shipping information of the customer, and
for each book in her shopping basket stocked in this warehouse, the number of copies bought. When
the customer's shopping session ends, all information about the shopping basket is removed but the
information about the warehouse shipping order is kept.
--------------------------------------------------------------------------------------------------------------------------
1. Page1: a login form that has text windows for username and password, a "Login" button, and a
"New users must register here" button.
2. Page2: a "Logout" button, a textarea, a "SearchByAuthor" button, a”SearchByBookTitle”, a
“ShoppingBasket” buttom and a section to display the results of the search in the proper HTML
format. Next to the “ShoppingBasket”, there must be a counter Showing number of items in
Shopping Basket.
3. Page3: a table showing all the items in the shopping basket with a “Buy” button. It should also
show the total price of the basket.
4. Page4: a form to fill out user information along with a "Register" button
When customer.php is executed for the first time, it displays Page1:
•If the user enters a wrong username/password and pushes "Login", it should go back to Page1
•If the user enters a correct username/password and pushes "Login", it should go to Page2
•If the user pushes the "New users must register here" button, it should go to Page4
•On Page2, If the user pushes “SearchByAuthor”, it should search the database for books
having the same author name, it will reload the Page2 with search results.
•On Page2, If the user pushes “SearchByTitle”, it should search the database for books having
the same title, it will reload the Page2 with search results.
•The search results will show the BookName, ISBN number, Number of books available
(stocks). It shouldn't show any books having its stocks = 0.
•On Page2, If the user pushes “ShoppingBasket”, it should go to Page3, showing all the items in
current shopping basket.
•On Page3, If the user pushes “Buy”. Its going to save users current basket to the database,
making appropriate queries to the tables ShoppingBasket, Contains and ShippingOrder. It will
also update the stocks of book updating the Stocks table.
----------------------------------------------------------------------------------------------------------------------