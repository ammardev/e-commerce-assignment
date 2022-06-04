# E-Commerce Assignment

Simple backend API E-Commerce project.

## Installation

You can run the project using Laravel Sail:
```bash
sail up -d
```

You need to run the migrations before starting using the API:
```bash
sail artisan migrate
```

## Usage

You can find the API reference in the following link:

https://documenter.getpostman.com/view/6231762/Uz5GpGMB

## Database Design

![image](https://user-images.githubusercontent.com/16087389/172025137-32d5a459-3dd5-46f2-b180-a94f0597af81.png)

As you can see. All prices are stored using integer data type. I chose this design to avoid inaccuracy problems with IEEE floating-point representation. The values may be divided by 100 on the frontend side. Or on the representation layer on the backend. And this should be discussed with the frontend team.

### Choosing Translations Representation

![image](https://user-images.githubusercontent.com/16087389/172025200-5d25daa1-eebf-47f1-a87b-99023430a8d5.png)

I chose model **B** over **A** and **C**.

Model **A** is the most simple and it is very easy to implement. But it has a big size in the database. Especially in the description field. While model **C** is better for future improvement. But it is harder to implement. And it is not needed for a simple project.

So I used model **B** because it is simple to implement and it can store any number of languages for the product. But it is harder to add more fields because we need to change the DB design every time. Anyway, This project won't expand or developed anymore. So, It is ok to use such a design.
