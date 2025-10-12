# TaskFlow: A Collaborative Task Management App
## 🎯 Purpose

TaskFlow is a collaborative task management web app that enables teams to plan, track, and manage projects visually — similar to Trello.
It demonstrates modern full-stack architecture with a Laravel backend and a Vue 3 frontend, focusing on real-world software design patterns, authentication, and drag-and-drop interactivity.

This project aims to showcase the developer’s ability to:

Design clean and modular **API-driven systems**

Implement **secure authentication** using Laravel Sanctum

Manage **relational data models** with migrations and Eloquent ORM

Build **interactive UIs** with Vue 3, Pinia, and TailwindCSS

## ⚙️ Tech Stack
Layer	Technology	Purpose

Backend: Laravel 11 + Sanctum	RESTful API, authentication, database management

Frontend:	Vue 3 + Vite + Pinia	Interactive, reactive UI with state management

Database:	MySQL / PostgreSQL	Persistent data storage for users, projects, tasks

UI Styling:	Tailwind CSS + Heroicons	Clean and responsive design

Tools:	Postman, phpMyAdmin, VS Code, Git	Testing, debugging, version control


## 🗓️ Development Timeline (4 Days)

### Day 1 – Backend Setup & Database Design

Goal: Build a working Laravel API and database structure.
Tasks:

Initialize Laravel project (laravel new taskflow)

Configure .env database connection

Create models and migrations:

users, projects, project_user, tasks, invitations

Define Eloquent relationships (User ↔ Project ↔ Task)

Implement RESTful routes for /api/projects and /api/tasks

Test APIs using Postman

Deliverable:
✅ Functional backend with API returning JSON data

### Day 2 – Authentication & Role Management

Goal: Implement secure login/register and user roles.
Tasks:

Install Laravel Breeze or Laravel Sanctum

Setup authentication routes: /register, /login, /logout

Create roles (Admin, Member) via role column or pivot table

Protect routes with middleware (auth:sanctum)

Test token-based authentication from Postman

Deliverable:
✅ Working authentication system with token-based API access

### Day 3 – Frontend Integration (Vue 3 + Pinia)

Goal: Connect Vue frontend to Laravel API.
Tasks:

Create Vue app (npm create vite@latest taskflow-frontend)

Set up Pinia for global state management (user, projects, tasks)

Build 3 key pages:

Login/Register Screen

Projects Dashboard (fetch user’s projects)

Project Board (Trello-like columns for tasks)

Use Axios to communicate with Laravel API

Implement logout & persistent session (store token in localStorage)

Deliverable:
✅ Functional UI connected to API (can log in and view projects)

### Day 4 – Task Board UX & Polish

Goal: Make the app visually appealing and interactive.
Tasks:

Implement drag-and-drop (using vue-draggable-next)

Add Task Detail Modal (edit title, description, due date, assignee)

Add Invite Members screen with email field and API integration

Apply TailwindCSS design system across pages

Test end-to-end workflow:
Create → Assign → Update → Complete task

Deliverable:
✅ Fully interactive and styled MVP ready for demo
