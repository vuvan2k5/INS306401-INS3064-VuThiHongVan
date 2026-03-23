# Session 07 - Part 1: Theory Warm-up

## 1. JOIN Distinction
- INNER JOIN: Returns only rows where there is a match in both tables.
- LEFT JOIN: Returns all rows from the left table, and unmatched rows will have NULL values for the right table.

## 2. Aggregation Logic
- WHERE filters rows before grouping.
- HAVING filters groups after aggregation.
- We cannot use WHERE to filter aggregate results like SUM() or COUNT().

## 3. PDO Definition
- PDO = PHP Data Objects.
- Advantages:
  1. Supports multiple database systems (MySQL, PostgreSQL, SQLite, etc.).
  2. Provides stronger security through Prepared Statements, preventing SQL Injection.

## 4. Security
- Prepared Statements separate SQL code from user input.
- User data is bound to placeholders, so it cannot alter the query structure → protects against SQL Injection.

## 5. Execution Flow
- Typical order of evaluation:
  1. WHERE (filters raw rows)
  2. GROUP BY (groups rows)
  3. HAVING (filters grouped results)
