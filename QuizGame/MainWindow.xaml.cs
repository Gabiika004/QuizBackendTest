using QuizGame.Models;
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

        public MainWindow()
        {
            InitializeComponent();
        }

        private async void UpdateData_Click(object sender, RoutedEventArgs e)
        {
            // Témakörök lekérése
            _topics = await _apiService.GetTopicsAsync();
            if (_topics == null || _topics.Count == 0)
            {
                MessageBox.Show("Hiba történt a témakörök lekérése közben.");
                return;
            }

            // Kérdések lekérése
            _questions = await _apiService.GetQuestionsAsync();
            if (_questions != null && _questions.Count > 0)
            {
                MessageBox.Show($"Adatok frissítve!");
            }
            else
            {
                MessageBox.Show("Hiba történt az adatok frissítése közben.");
            }
        }


        private void StartGame_Click(object sender, RoutedEventArgs e)
        {
            if (_questions == null || _questions.Count == 0)
            {
                MessageBox.Show("Kérlek, először frissítsd az adatokat!");
                return;
            }

            _score = 0;
            _currentQuestionIndex = 0;
            Score.Text = $"Pontszám: {_score}";  // Pontszám frissítése a felhasználói felületen
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

    }
}