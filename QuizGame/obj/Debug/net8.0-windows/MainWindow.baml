   M S B A M L   `   `   `  ����  QuizGame    QuizGame.MainWindow   5   	   W SPresentationCore, Version=8.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=8.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35e aSystem.Windows.Controls.Ribbon, Version=8.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089R NWindowsBase, Version=8.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35F 9http://schemas.microsoft.com/winfx/2006/xaml/presentation     5   	   R NSystem.Xaml, Version=8.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	     � WindowStartupLocation$  CenterScreen=�5   	    � Title$ Kvíz Játék��5   	   $	��450��6   $	��800��6)   .��5
      � $��10q�6    � RowDefinitions 5   
   �� 5      $
��Auto �6   �� 5      $��* �6   �� 5      $
��Auto �6    � ColumnDefinitions 5   
   �� 5      �� 5      �� 5      $
��auto �6   .+�5   
   �� -   5         ��Name$ Topic��5      $��2��6#   $��Center=�67   $
��Bold"�6T   $��16(�6f   
����  �$��0��6�   �� 5   
   -   5        $ Question��5      $��1��6&   $��2��63   $��Center=�6G   $
��Bold"�6d   $��30(�6v   $
��Wrap=�6�   $
��0,20q�6�   �� 5   
   $��2��6   $��2��6"    �� Orientation$ Vertical=�66   $��	10,0,10,0q�6M   .+�5      �� -   5         ��Name$ Answer1��5      $	��0,5q�6&   $��50��6H   �� 5      -   5        $ Answer2��5      $	��0,5q�6&   $��50��6H   �� 5      -   5        $ Answer3��5      $	��0,5q�6&   $��50��6H   �� 5      -   5        $ Answer4��5      $	��0,5q�6&   $��50��6H   5      �� 5    
   $��2��6   $��2��6%   .+�5!      �� -   5        $ HalfBoosterButton��5!      $��Felező��60   $��5q�6A   $��40��6L   6X   �� 5"      -   5        $ AudienceBoosterButton��5"      $��Közönség��64   $��5q�6G   $��40��6R   �� 5$      -	   5        $ PhoneBoosterButton��5$      $��Telefonhívás��61   $��5q�6H   $��40��6S   5&      �� 5(   
   $��3��6   $��2��6"   $ Vertical=�62   $��Center=�6I   $��Center=�6d   $
��0,20q�6�   .+�5)      �� -
   5        $ 
UpdateData��5)      $��Adatok frissítése��6)   $��5q�6^   $��40��6i   $	��100��6u   �� 5*      -   5        $ 	StartGame��5*      $��Játék kezdése��6(   $��5q�6X   $��40��6c   $	��100��6o   �� 5+      -   5        $ Score��5+      $��Center=�6'   $��Pontszám: 0��6B   $��16(�6U   $
��20,0q�6c   5,      5-      5.      