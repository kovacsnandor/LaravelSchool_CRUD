SELECT * from sports;
SELECT * from students;
SELECT * from schoolclasses;
SELECT * from playingsports;


SELECT sc.osztalyNev, COUNT(*) letszam from students st
  inner join schoolclasses sc on sc.id  = st.schoolclassId
GROUP by sc.osztalyNev;


SELECT osztondij, min(atlag), max(atlag) from students
  group by osztondij;


SELECT st.diakNev, st.szulDatum, sc.osztalyNev, FLOOR(DATEDIFF(CURDATE(), szulDatum) / 365.25) eletkor from students st
  inner JOIN schoolclasses sc on sc.id = st.schoolclassId
  order by eletkor;


SELECT sc.osztalyNev, FLOOR(DATEDIFF(CURDATE(), szulDatum) / 365.25) eletkor from students st
  inner JOIN schoolclasses sc on sc.id = st.schoolclassId
  GROUP by sc.osztalyNev;


SELECT FLOOR(DATEDIFF(CURDATE(), szulDatum) / 365.25) eletkor, GROUP_CONCAT(distinct sc.osztalyNev order BY sc.osztalyNev DESC SEPARATOR ', ') osztalyok from students st
   inner JOIN schoolclasses sc on sc.id = st.schoolclassId
  group by eletkor;


SELECT FLOOR(DATEDIFF(CURDATE(), szulDatum) / 365.25) eletkor, GROUP_CONCAT(st.diakNev order BY st.diakNev SEPARATOR ', ') osztalyok from students st
   inner JOIN schoolclasses sc on sc.id = st.schoolclassId
  group by eletkor;
