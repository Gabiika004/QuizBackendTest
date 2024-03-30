using QuizGame.Models;
using System.Globalization;
using System.Text;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace QuizGame
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        private QuizApiService _apiService = new QuizApiService();
        private List<Question> _questions;
        private List<Topic> _topics;
        private int _currentQuestionIndex = 0;
        private int _score = 0;
        private int defaultUserId = 1;
        private bool isHalfBoosterUsed = false;

        public MainWindow()
        {
            InitializeComponent();
            DisableBoosterButtonsState(false);
        }

        private async Task UpdateDatas()
        {
            _topics = await _apiService.GetTopicsAsync();
            _questions = await _apiService.GetQuestionsAsync();
            if (_topics == null || _questions == null || _questions.Count == 0)
            {
                MessageBox.Show("Hiba történt az adatok frissítése közben.");
            }
            else
            {
                MessageBox.Show($"Adatok frissítve!");
            }
        }

        private async void UpdateData_Click(object sender, RoutedEventArgs e)
        {
            await UpdateDatas();
        }


        private async void StartGame_Click(object sender, RoutedEventArgs e)
        {
            // Feltételezve, hogy van egy alapértelmezett felhasználói ID

            if (_questions == null || _questions.Count == 0)
            {
                MessageBox.Show("Kérlek, először frissítsd az adatokat!");
                return;
            }

            // Booster logika hozzáadása
            var resetSuccess = await _apiService.ResetUserBoostersAsync(defaultUserId);
            if (!resetSuccess)
            {
                MessageBox.Show($"Nem sikerült resetelni a boostereket.");
                return;

            }

            // Sikeres reset után frissítsük a boosterek állapotát a felhasználói felületen
            // Például aktiváljuk a booster gombokat
            await FetchAndSetupUserBoosters(defaultUserId); // Booster gombok beállítása

            // Játékállapot inicializálása
            _score = 0;
            _currentQuestionIndex = 0;
            Score.Text = $"Pontszám: {_score}";
            DisplayCurrentQuestion();
        }

        private void DisplayCurrentQuestion()
        {
            if (_currentQuestionIndex < _questions.Count)
            {
                var currentQuestion = _questions[_currentQuestionIndex];
                var topic = _topics.FirstOrDefault(t => t.Id == currentQuestion.TopicId);
                var topicName = topic != null ? topic.TopicName : "Ismeretlen téma";

                Topic.Text = $"Téma: {topicName}";
                Question.Text = currentQuestion.QuestionText;

                // Feltételezve, hogy van elegendő válasz minden kérdéshez
                Answer1.Content = currentQuestion.Answers[0].AnswerText;
                Answer2.Content = currentQuestion.Answers[1].AnswerText;
                Answer3.Content = currentQuestion.Answers[2].AnswerText;
                Answer4.Content = currentQuestion.Answers[3].AnswerText;

                // Válasz gombok Tag beállítása
                SetAnswerButtonsTag();
                isHalfBoosterUsed = false; // Minden új kérdésnél visszaállítjuk, hogy a booster újra használható legyen
            }
            else
            {
                MessageBox.Show($"A játék véget ért! Pontszámod: {_score}");
                // Lehetőség új játék indítására
            }
        }

        private void Answer_Click(object sender, RoutedEventArgs e)
        {
            var button = (Button)sender;
            var answerIndex = int.Parse(button.Tag.ToString());
            var isCorrect = _questions[_currentQuestionIndex].Answers[answerIndex].IsCorrect;

            if (isCorrect)
            {
                _score += 100;
                MessageBox.Show("Helyes válasz!");
                Score.Text = $"Pontszám: {_score}";  // Pontszám frissítése
            }
            else
            {
                MessageBox.Show("Helytelen válasz!");
            }

            _currentQuestionIndex++;
            DisplayCurrentQuestion();
        }

        private void SetAnswerButtonsTag()
        {
            Answer1.Tag = 0;
            Answer2.Tag = 1;
            Answer3.Tag = 2;
            Answer4.Tag = 3;
        }

        private void DisableBoosterButtonsState(bool enabled)
        {
            // Itt állítható be minden booster gomb állapota
            HalfBoosterButton.IsEnabled = enabled;
            AudienceBoosterButton.IsEnabled = enabled;
            PhoneBoosterButton.IsEnabled = enabled;
        }



        private async void HalfBoosterButton_Click(object sender, RoutedEventArgs e)
        {
            // Feltételezzük, hogy a HalfBoosterButton-nak van egy Tag tulajdonsága, ami tartalmazza a boosterId-t
            if (int.TryParse(HalfBoosterButton.Tag.ToString(), out int boosterId))
            {
                var success = await _apiService.UseBoosterAsync(defaultUserId, boosterId); // Itt a defaultUserId-t és a boosterId-t adjuk át
                if (success)
                {
                    // Booster sikeres használata esetén deaktiváljuk a gombot
                    HalfBoosterButton.IsEnabled = false;

                    // Itt implementálhatod a booster hatását is, pl. felezzük a válaszlehetőségek számát
                    ApplyHalfBoosterEffect();
                }
                else
                {
                    MessageBox.Show("Nem sikerült használni a boostert.");
                }
            }
            else
            {
                MessageBox.Show("Nem sikerült azonosítani a booster ID-t.");
            }
        }


        private async Task FetchAndSetupUserBoosters(int userId)
        {
            var userBoosters = await _apiService.GetUserBoostersByUserIdAsync(userId);
            if (userBoosters == null || userBoosters.Count == 0)
            {
                MessageBox.Show("Nincsenek boosterek beállítva ehhez a felhasználóhoz.");
                return;
            }

            foreach (var userBooster in userBoosters)
            {
                Button boosterButton = FindBoosterButtonByName(userBooster.Booster.Boostername);

                if (boosterButton == null)
                {
                    // Hibakeresés: logoljuk, ha nem találunk gombot
                    MessageBox.Show($"Nem található gomb a következő booster névvel: {userBooster.Booster.Boostername}");
                    continue;
                }

                boosterButton.IsEnabled = !userBooster.Used;
                boosterButton.Tag = (int)userBooster.Booster.Id; // Feltételezve, hogy az Id int típusú

            }
        }


        // Segédfüggvény a booster neve alapján megfelelő gomb keresésére
        private Button FindBoosterButtonByName(string boosterName)
        {
            // Először normalizáljuk a boosterName értéket, hogy nagybetűvel kezdődjön, és egyezzen a gombok Content attribútumával
            var normalizedBoosterName = CultureInfo.CurrentCulture.TextInfo.ToTitleCase(boosterName);

            // Az átalakított boosterName alapján keresünk megfelelő gombot
            switch (normalizedBoosterName)
            {
                case "Felező":
                    return HalfBoosterButton;
                case "Közönség":
                    return AudienceBoosterButton;
                case "Telefonhívás":
                    return PhoneBoosterButton;
                default:
                    Console.WriteLine($"Nem található gomb a következő booster névvel: {normalizedBoosterName}");
                    return null;
            }
        }



        private void ApplyHalfBoosterEffect()
        {
            if (!isHalfBoosterUsed) return;
            var currentAnswers = _questions[_currentQuestionIndex].Answers;
            var incorrectAnswers = currentAnswers.Where(a => !a.IsCorrect).ToList();

            // Vegyük csak a helytelen válaszokat, és válasszunk belőlük véletlenszerűen kettőt eltávolítani
            Random rand = new Random();
            while (incorrectAnswers.Count > 2)
            {
                var toRemove = incorrectAnswers[rand.Next(incorrectAnswers.Count)];
                incorrectAnswers.Remove(toRemove);
            }

            // Deaktiváljuk a kiválasztott rossz válaszokat megjelenítő gombokat
            foreach (var answer in incorrectAnswers)
            {
                var button = FindButtonByAnswerText(answer.AnswerText);
                if (button != null)
                {
                    button.IsEnabled = false; // Vagy elrejtheted őket, attól függően, hogy milyen UX-t szeretnél.
                }
            }
        }

        private Button FindButtonByAnswerText(string answerText)
        {
            // Ebben a metódusban megkeressük azt a gombot, amely az adott válaszszöveget jeleníti meg
            if (Answer1.Content.ToString() == answerText) return Answer1;
            if (Answer2.Content.ToString() == answerText) return Answer2;
            if (Answer3.Content.ToString() == answerText) return Answer3;
            if (Answer4.Content.ToString() == answerText) return Answer4;
            return null;
        }


    }
}