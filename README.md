# Projekt-BaFiS - Twoja baza filmów i seriali
Projekt napisany przy użyciu frameworka [Symfony 4.1](https://symfony.com/)

### Wymagania
* MariaDB 10.2 i wyższa (brak obsługi typu JSON w niższych wersjach)

### Co powinien zawierać nasz projekt:
1. Baza aktualnych filmów i seriali z wyszczególnieniem: tytuł, gatunek (jako tag), reżyser, autorzy scenariusza, obsada, produkcja, czas trwania, data premiery, ilość odcinków, ilość sezonów,
2. Możliwość śledzenia indywidualnego progresu w danym serialu/filmie (obejrzany, do obejrzenia, aktualnie oglądany) ,
3. wyszukiwanie produkcji według indywidualnych potrzeb za pomocą filtrów, 
4. Ocenianie produkcji (gwiazdkami od 1 do 5),
5. Wyświetlanie statystyk dla produkcji (średnia ocena, ilość ocen, ilość osób chcących obejrzeć tą produkcję),
6. Wyświetlanie statystyk użytkownika (ulubiony gatunek, ulubiony reżyser, średnia ocena, ilość obejrzanych produkcji) na jego osobistej stronie profilowej,
7. System rekomendowania będzie wyliczał ilość punktów produkcji dla konkretnego użytkownika na podstawie jego preferencji takich jak: ulubiony gatunki, reżyser, scenariusz, obsada, produkcja, a także na podstawie średniej oceny danej produkcji. Parametry takie jak np. Średnia ocena będą miały większą wagę, a co za tym idzie konkretne produkcje będą wyświetlane wyżej w naszym systemie rekomendacji,
8. System rejestracji i logowania użytkowników
9. System administracji aplikacją:
   * Dodawanie, edytowanie, usuwanie produkcji,
   * Nadawanie ról i usuwanie użytkowników,
   * Wyświetlanie statystyk związanych z użytkowaniem serwisu
