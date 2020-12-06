# Football-games
Тестовое задание

Есть таблица teams поля, упрощенно:
id (int)
name (varchar)

Есть таблица games с полями
id (int) — id игры
done (пусть тоже int, не критично) — признак того, что игру "сыграли": 0 или 1 (логичнее тут
использовать BOOLEAN, но сейчас нет никакой разницы)
k1 (int) — id команды1
k2 (int) — id команды2
g1 (int) — сколько забила команда1
g2 (int) — сколько забила команда2

Задача: построить турнирную таблицу, речь идет о футболе, используя разумное число запросов.
В турнирной таблице отражаются следующие показатели:
И — число сыграных командой игр
В — сколько игр выиграно
П — сколько игр проиграно
Н — сколько игр сыграно в ничью
МЗ, МП — соотв. число забитых/пропущенных мячей
О — очки (за победу - 3 очка, за ничью -1 очко, за поражение — ноль)
