using System.Net.Http;
using System.Threading.Tasks;
using System.Collections.Generic;
using Newtonsoft.Json;
using QuizGame.Models;
using System.Text;
using System.Windows;

public class QuizApiService
{
    private readonly HttpClient _httpClient;
    private readonly string _baseUrl = "http://127.0.0.1:8000/api"; // Cseréld le a saját URL-edre

    public QuizApiService()
    {
        _httpClient = new HttpClient();
    }

    public async Task<List<Question>> GetQuestionsAsync()
    {
        var response = await _httpClient.GetAsync($"{_baseUrl}/questions");
        if (response.IsSuccessStatusCode)
        {
            var content = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<List<Question>>(content);
        }
        return null;
    }

    public async Task<List<Topic>> GetTopicsAsync()
    {
        var response = await _httpClient.GetAsync($"{_baseUrl}/topics");
        if (response.IsSuccessStatusCode)
        {
            var content = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<List<Topic>>(content);
        }
        return null;
    }

    public async Task<bool> ResetUserBoostersAsync(int userId)
    {
        var response = await _httpClient.PostAsync($"{_baseUrl}/userboosts/reset/{userId}", null);
        if (!response.IsSuccessStatusCode)
        {
            var errorContent = await response.Content.ReadAsStringAsync();
            MessageBox.Show($"Hibakód: {response.StatusCode}, Hibaüzenet: {errorContent}");
            return false;
        }
        return true;
    }


    public async Task<List<UserBooster>> GetUserBoostersByUserIdAsync(int userId)
    {
        try
        {
            var response = await _httpClient.GetAsync($"{_baseUrl}/userboosts/user/{userId}");
            if (response.IsSuccessStatusCode)
            {
                var content = await response.Content.ReadAsStringAsync();
                var userBoostersArray = UserBooster.FromJson(content); // Tömb deszerializálása
                return new List<UserBooster>(userBoostersArray); // Átalakítás listává
            }
            else
            {
                // Hiba logolása, ha a válasz nem sikerült
                Console.WriteLine($"Hiba: A szerver {response.StatusCode} státuszkódot adott vissza.");
            }
        }
        catch (Exception ex)
        {
            // Deszerializálási hiba logolása
            Console.WriteLine($"Deszerializálási hiba: {ex.Message}");
        }
        return null;
    }



    //public async Task<bool> UseBoosterAsync(int userBoosterId)
    //{
    //    var requestContent = new StringContent(JsonConvert.SerializeObject(new { used = true }), Encoding.UTF8, "application/json");
    //    var response = await _httpClient.PutAsync($"{_baseUrl}/userboosts/{userBoosterId}", requestContent); // Használjuk a PUT metódust az update-hez
    //    return response.IsSuccessStatusCode;
    //}

    public async Task<bool> UseBoosterAsync(int userId, int boosterId)
    {
        var requestContent = new StringContent(
            JsonConvert.SerializeObject(new { userid = userId, boosterid = boosterId, used = true }),
            Encoding.UTF8,
            "application/json");

        var response = await _httpClient.PutAsync($"{_baseUrl}/userboosts/use", requestContent);

        if (!response.IsSuccessStatusCode)
        {
            var errorContent = await response.Content.ReadAsStringAsync();
            MessageBox.Show($"Hiba történt: Kód: {response.StatusCode}, Üzenet: {errorContent}", "Hiba", MessageBoxButton.OK, MessageBoxImage.Error);
        }

        return response.IsSuccessStatusCode;
    }


    // Esetleges további booster kezelő metódusok...

    // További API hívások...
}
