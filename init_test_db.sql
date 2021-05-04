BEGIN
    BEGIN TRY
        -- パスワード設定ポリシーを下げる
        -- set global validate_password.policy=low;
        -- 新規ユーザーを削除する
        drop user pelo;
        -- 新規ユーザーを作成する
        create user pelo@'%' identified by '';
    END TRY

    BEGIN CATCH
        PRINT ERROR_NUMBER()
    END CATCH
END
