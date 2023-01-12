SELECT
COUNT(
DISTINCT tpianta.idSpeciePianta
) AS piniCount,
tparco.nomeParco AS parco
FROM
tpianta
INNER JOIN tspeciepianta ON tspeciepianta.id = tpianta.idSpeciePianta
INNER JOIN tgenere ON tgenere.id = tspeciepianta.idGenere
INNER JOIN tparco ON tparco.id = 2
WHERE
tpianta.idParco = 2 AND tgenere.nomeGenere = 'Pino';