Var
    Name{, Line}: String;
begin
    Name := IdFTP1.DirectoryListing.Items[ListBox1.ItemIndex].FileName;
    SaveDialog1.FileName := Name;
    if SaveDialog1.Execute then begin
        IdFTP1.Get(Name, SaveDialog1.FileName, true);
    end;
end;