class RenameOccurencesToOccurrences < ActiveRecord::Migration[5.2]
  def change
    rename_column :recurring_todos, :number_of_occurences, :number_of_occurrences
    rename_column :recurring_todos, :occurences_count, :occurrences_count
  end
end
