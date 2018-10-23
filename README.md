# Projekt-BaFiS - Twoja baza filmów i seriali
Projekt napisany przy użyciu frameworka [Symfony 4.1](https://symfony.com/)

Co powinien zawierać nasz projekt:
1. Baza aktualnych filmów i seriali z wyszczególnieniem: tytuł, gatunek (jako tag), reżyser, autorzy scenariusza, obsada, produkcja, czas trwania, data premiery, ilość odcinków, ilość sezonów,
2. możliwość śledzenia indywidualnego progresu w danym serialu/filmie (obejrzany, do obejrzenia, aktualnie oglądany) ,
3. wyszukiwanie produkcji według indywidualnych potrzeb za pomocą filtrów, 
4. ocenianie produkcji (gwiazdkami od 1 do 5),
5. wyświetlanie statystyk dla produkcji (średnia ocena, ilość ocen, ilość osób chcących obejrzeć tą produkcję),
6. Wyświetlanie statystyk użytkownika (ulubiony gatunek, ulubiony reżyser, średnia ocena, ilość obejrzanych produkcji) na jego osobistej stronie profilowej,
7. system rekomendowania będzie wyliczał ilość punktów produkcji dla konkretnego użytkownika na podstawie jego preferencji takich jak: ulubiony gatunki, reżyser, scenariusz, obsada, produkcja, a także na podstawie średniej oceny danej produkcji. Parametry takie jak np. Średnia ocena będą miały większą wagę, a co za tym idzie konkretne produkcje będą wyświetlane wyżej w naszym systemie rekomendacji,
8. System administracji aplikacją:
   * Dodawanie, edytowanie, usuwanie produkcji,
   * Dodawanie, edytowanie, usuwanie użytkowników,
   * Wyświetlanie statystyk związanych z użytkowaniem serwisu
