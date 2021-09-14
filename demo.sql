SELECT (
        COALESCE(
            SUM(IFNULL(EVENT.duration, 0)),
            0
        ) + COALESCE(
            SUM(IFNULL(sickleave.duration, 0)),
            0
        ) + COALESCE(
            SUM(
                IFNULL(timeofffield.duration, 0),
                0
            )
        ) + COALESCE(
            SUM(IFNULL(otherleave.duration, 0)),
            0
        )
    )
FROM EVENT
    JOIN sickleave ON sickleave.userID = EVENT.userID
    AND sickleave.date = EVENT.date
    JOIN timeofffield ON timeofffield.userID = EVENT.userID
    AND timeofffield.date = EVENT.date
    JOIN otherleave ON otherleave.userID = EVENT.userID
    AND otherleave.date = EVENT.date
WHERE EVENT.userID = 2
    AND EVENT.date = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)
SELECT (
        IFNULL(SUM(event.duration), 0) + IFNULL(SUM(sickleave.duration), 0) + IFNULL(SUM(otherleave.duration), 0) + IFNULL(SUM(timeofffield.duration), 0)
    ) AS duration
FROM EVENT
    JOIN sickleave ON sickleave.userID = EVENT.userID
    AND sickleave.date = EVENT.date
    JOIN timeofffield ON timeofffield.userID = EVENT.userID
    AND timeofffield.date = EVENT.date
    JOIN otherleave ON otherleave.userID = EVENT.userID
    AND otherleave.date = EVENT.date
WHERE EVENT.userID = 2
    AND EVENT.date = DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY)